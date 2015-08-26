<?php

class Event extends BaseController
{
    public function __construct($action, $urlParams)
    {
        parent::__construct($action, $urlParams);
    }

    //Event creation
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

    //Search
    protected function Search()
    {
        //Check if post
        if(CHelper::IsPost())
        {
            $model = new EventModel("Search", true);
            $model->setPageTitle('Search');
            $this->ReturnView($model->view);
        }
        else
        {
            //get
            //is not post, cannot contain post variables,
            //redirect to home
            $this->Redirect('home');
        }
    }

    //Image upload, event specific
    public function ImageUpload()
    {
        //Create unique GUID
        $guid = CHelper::GetGUID();

        //Set server directory
        $ds = DIRECTORY_SEPARATOR;
        $storeFolder = '/var/www/public/app_data/event_images/';

        //If files are set
        if (!empty($_FILES)) {

            $temp = explode(".", $_FILES["file"]["name"]);
            $newfilename = $guid . '.' . end($temp);

            //Move image to event_images
            move_uploaded_file($_FILES["file"]["tmp_name"], $storeFolder . $newfilename);

            //Set header to json and return filename
            header('Content-Type: application/json');
            echo json_encode($newfilename);
            exit();
        }
    }

    //Event Detail
    public function Detail($id)
    {
        $model = new EventModel("Detail", false, array($id));

        //echo '<pre>'; print_r($model->view->event); exit();

        $model->setPageTitle($model->view->event['name']);
        $this->ReturnView($model->view);
    }

    //RSVP
    public function RSVP()
    {
        $eventDateId = json_decode(file_get_contents('php://input'), true);
        $model = new EventModel("RSVP", true, array($eventDateId));
    }
}