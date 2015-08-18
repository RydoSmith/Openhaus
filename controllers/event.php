<?php

class Event extends BaseController
{
    public function __construct($action, $urlParams)
    {
        parent::__construct($action, $urlParams);
    }

    protected function Create()
    {
        //Check user is logged in
        if(!CHelper::IsLoggedIn())
        {
            $this->Redirect('account', 'login', 'createevent');
        }

        //Check if is post
        if(CHelper::IsPost())
        {
            //POST
            $model = new EventModel("Create", true);

            //Error checking
            if($model->hasError())
            {
                $model->setPageTitle('Create Event');
                $this->ReturnViewByName("create", $model->view, "layout");
                exit();
            }

            $this->Redirect('home');
        }
        else
        {
            //GET
            $model = new EventModel("Create");
            $model->setPageTitle('New Event');
            $this->ReturnView($model->view);
        }
    }

    public function ImageUpload()
    {
        $guid = CHelper::GetGUID();

        $ds = DIRECTORY_SEPARATOR;
        $storeFolder = '/var/www/public/app_data/event_images/';

        if (!empty($_FILES)) {

            $temp = explode(".", $_FILES["file"]["name"]);
            $newfilename = $guid . '.' . end($temp);
            move_uploaded_file($_FILES["file"]["tmp_name"], $storeFolder . $newfilename);

            header('Content-Type: application/json');
            echo json_encode($guid);
            exit();
        }
    }
}