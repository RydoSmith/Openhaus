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

            $this->Redirect('event', 'detail', $model->view->post['id']);
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

        //Get variables from string
        $queryVarString  = explode("&", explode("?", $_SERVER['REQUEST_URI'])[1] );
        $vars = array();
        foreach($queryVarString as $qvs)
        {
            array_push($vars, preg_split('/=/', $qvs));
        }

        //Check if post
        $model = new EventModel("Search", false, $vars);
        $model->setPageTitle('Search');
        $this->ReturnView($model->view);
    }

    //Image upload, event specific
    public function ImageUpload()
    {
        //echo '<pre>'; print_r($_FILES); exit();

        if(empty($_FILES['file']['name']))
        {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode("There was a problem with this image, try a different one!");
            exit();
        }

        if(!empty($_FILES['file']['name']))
        {
            if($_FILES['file']['type'] != 'image/jpeg' && $_FILES['file']['type'] != 'image/png' && $_FILES['file']['type'] != 'image/pjpeg')
            {
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode("Invalid file type, must be .jpg, .jpeg or .png");
                exit();
            }

            if($_FILES['file']['size'] > 400000)
            {
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode("Image too large, must be smaller than 4mb");
                exit();
            }
        }

        //Create unique GUID
        $guid = CHelper::GetGUID();

        //Set server directory
        $ds = DIRECTORY_SEPARATOR;
        $storeFolder = '/var/www/public/app_data/event_images/';

        //If files are set
        if (!empty($_FILES['file']['name'])) {

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