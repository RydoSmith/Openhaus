<?php

abstract class BaseModel
{
    protected $database, $config;
    public $view;

    public function __construct($config)
    {
        $this->config = $config;
        $this->database = $this->getDatabaseConnection($config);
        $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->view = new stdClass();
        $this->view->modelErrors = array();
        $this->view->hasError = false;
    }

    //Database
    function getDatabaseConnection($config) {
        static $dbLink;
        if (!($dbLink instanceof PDO)) {
            try {
                $dsn = "mysql:host=".$config['db_location'].";dbname=".$config['db_name'];
                $dbLink = new PDO($dsn, $config['db_user'], $config['db_pass']);
            }
            catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        return $dbLink;
    }

    //Errors
    public function addModelError($field, $modelError)
    {
        $this->view->modelErrors[$field] = $modelError;
    }
    public function hasError()
    {
        return count($this->view->modelErrors) > 0 ? true : false;
    }
    public function add($property, $value)
    {
        $this->view->$property = $value;
    }

    //Set page title
    public function setPageTitle($x)
    {
        $this->view->pageTitle = $x;
    }

    //Set message
    public function setMesssage($type, $title, $message)
    {
        if($type == MessageType::Success)
        {
            $this->setSuccessMessage($title, $message);
        }
        else if($type == MessageType::Error)
        {
            $this->setErrorMessage($title, $message);
        }
        else if($type == MessageType::Warning)
        {
            $this->setWarningMessage($title, $message);
        }
        else
        {
            $this->setInfoMessage($title, $message);
        }
    }

    //Create message display
    public function setSuccessMessage($title, $message)
    {
        $this->view->message =  "<div class=\"alert alert-success\"><span class=\"title\">".$title."</span><span class=\"message\">".$message."</span><span class=\"close\">x</span></div>";
    }
    public function setErrorMessage($title, $message)
    {
        $this->view->message =  "<div class=\"alert alert-danger\"><span class=\"title\">".$title."</span><span class=\"message\">".$message." (click to close)</span><span class=\"close\">x</span></div>";
    }
    public function setWarningMessage($title, $message)
    {
        $this->view->message =  "<div class=\"alert alert-warning\"><span class=\"title\">".$title."</span><span class=\"message\">".$message." (click to close)</span><span class=\"close\">x</span></div>";
    }
    public function setInfoMessage($title, $message)
    {
        $this->view->message =  "<div class=\"alert alert-info\"><span class=\"title\">".$title."</span><span class=\"message\">".$message." (click to close)</span><span class=\"close\">x</span></div>";
    }

    //User
    public function getUserID()
    {
        if(isset($_SESSION) && $_SESSION['LoggedIn'] == 1 && isset($_SESSION['Username']))
        {
            $sql = "SELECT id FROM users WHERE email=:e LIMIT 1";
            if($stmt = $this->database->prepare($sql))
            {
                $stmt->bindParam(':e', $_SESSION['Username'], PDO::PARAM_STR);
                $stmt->execute();
                $id = $stmt->fetch()['id'];
                $stmt->closeCursor();
                return $id;
            }
        }
        else
        {
            return null;
        }
    }

    //Get Account Info
    public function GetAccountInfo()
    {
        $e = $_SESSION['Username'];

        $sql = "SELECT * FROM users WHERE email=:email";
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':email', $e, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch();

            $stmt->closeCursor();



            $this->view->account = new stdClass();
            $this->view->account->id = $row['id'];
            $this->view->account->first_name = $row['first_name'];
            $this->view->account->last_name = $row['last_name'];
            $this->view->account->full_name = $row['first_name'].' '.$row['last_name'];
        }
    }

    //Is User Logged In
    public function IsUserLoggedIn()
    {
        if(isset($_SESSION) && isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] == 1 && isset($_SESSION['Username']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    //GetById
    public function GetById($table, $id)
    {
        $sql = "SELECT * FROM ".$table." WHERE id=:id";
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }


    //
    //EVENT HELPERS
    //

    //Gets all event related data
    public function GetEventRelatedData($event)
    {
        //Get Event Dates
        $sql = "SELECT * FROM event_dates WHERE event_id=:eid";
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':eid', $event['id'], PDO::PARAM_STR);
            $stmt->execute();
            $event['dates'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        //Get Event Keywords
        $sql = "SELECT * FROM event_keywords WHERE event_id=:eid";
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':eid', $event['id'], PDO::PARAM_STR);
            $stmt->execute();
            $event['keywords'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        //Get Event Images
        $event_images = null;
        $sql = "SELECT * FROM event_images WHERE event_id=:eid";
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':eid', $event['id'], PDO::PARAM_STR);
            $stmt->execute();
            $event_images = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        //echo '<pre>'; print_r($event_images); exit();

        //Get Images
        $event['images'] = array();
        foreach($event_images as $ei)
        {
            $sql = "SELECT * FROM images WHERE id=:id";
            if($stmt = $this->database->prepare($sql))
            {
                $stmt->bindParam(':id', $ei['image_id'], PDO::PARAM_STR);
                $stmt->execute();
                array_push($event['images'], $stmt->fetch(PDO::FETCH_ASSOC));
            }
        }

        return $event;
    }

    //Search events based on search parameters
    public function GetSearchResults($sql, $params = array())
    {
        //Get events based on query parameters
        if($stmt = $this->database->prepare($sql))
        {
            //Check if params is set
            //params are used to bind values to the query using PDO
            if(count($params) > 0)
            {
                foreach($params as $param)
                {
                    $stmt->bindParam($param['bind'], $param['value'], PDO::PARAM_STR);
                }
            }

            $stmt->execute();
            $row = $stmt->fetchAll();
        }

        $events = array();
        $count = 0;

        foreach($row as $e)
        {
            //echo '<pre>'; print_r($e); exit();

            $count++;
            $events[$count] = array();

            $events[$count]['id'] = $e['id'];
            $events[$count]['user_id'] = $e['user_id'];
            $events[$count]['location'] = $e['location'];
            $events[$count]['price'] = $e['price'];
            $events[$count]['bedrooms'] = $e['bedrooms'];
            $events[$count]['bathrooms'] = $e['bathrooms'];
            $events[$count]['type'] = $e['type'];
            $events[$count]['name'] = $e['name'];
            $events[$count]['description'] = $e['description'];
            $events[$count]['privacy'] = $e['privacy'];

            $events[$count] = $this->GetEventRelatedData($events[$count]);
        }

        //echo '<pre>'; print_r($events); exit();
        return $events;
    }

    //Get events based on location
    public function GetEventsNearLocation($location)
    {
        if($location == null)
        {
            $sql = "SELECT * FROM events LIMIT 6";
            if($stmt = $this->database->prepare($sql))
            {
                $stmt->execute();
                $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            $events = array();
            $count = 0;

            foreach($row as $e)
            {
                //echo '<pre>'; print_r($e); exit();

                $count++;
                $events[$count] = array();

                $events[$count]['id'] = $e['id'];
                $events[$count]['user_id'] = $e['user_id'];
                $events[$count]['location'] = $e['location'];
                $events[$count]['price'] = $e['price'];
                $events[$count]['bedrooms'] = $e['bedrooms'];
                $events[$count]['bathrooms'] = $e['bathrooms'];
                $events[$count]['type'] = $e['type'];
                $events[$count]['name'] = $e['name'];
                $events[$count]['description'] = $e['description'];
                $events[$count]['privacy'] = $e['privacy'];

                $events[$count] = $this->GetEventRelatedData($events[$count]);
            }

            //echo '<pre>'; print_r($events); exit();
            return $events;
        }

    }





}