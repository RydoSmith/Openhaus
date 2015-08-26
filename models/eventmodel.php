<?php

class EventModel extends BaseModel
{
    public function __construct($action, $isPost = false, $params = array())
    {
        parent::__construct(include('conf/config.php'));
        if ($isPost) {
            call_user_func_array(array($this, $action . '_POST'), $params);
        } else {
            call_user_func_array(array($this, $action), $params);
        }
    }

    //
    //Event creation
    //
    public function Create()
    {
        parent::GetAccountInfo();
    }
    public function Create_POST()
    {
        parent::GetAccountInfo();

        //
        //Get posted variables
        //

        //Get Dates and Times and convert to MySQL Date and Time format
        $dates = array(); //[array[date, time]]
        for($i = 0; $i < count($_POST['dates']); $i++)
        {
            $parts = explode('-', $_POST['dates'][$i]);
            $dates[$i] = array
            (
                'date' => date('Y-m-d', strtotime(str_replace('-', '/', $parts[0]))),
                'start_time' => date('H:i:s', strtotime($parts[1])),
                'end_time' => date('H:i:s', strtotime($parts[2]))
             );
        }

        $location = $_POST['location'];
        $currency  = $_POST['currency'];
        $price  = $_POST['price'];
        $bedrooms = $_POST['bedrooms'];
        $bathrooms = $_POST['bathrooms'];
        $type = $_POST['type'];

        //Get selected tags
        $tags = array();
        foreach($_POST['tags'] as $tag)
        {
            array_push($tags, $tag);
        }

        //Get image guids
        $images = array();
        foreach($_POST['images'] as $image)
        {
            array_push($images, $image);
        }

        $event_name = $_POST['event_name'];
        $event_description= $_POST['event_description'];
        $privacy = $_POST['privacy'];

        //
        //TO DO: VALIDATION !!!!!!IMPORTANT!!!!!!
        //

        //
        //INSERT EVENT AND GET event_id variable
        //
        $event = array
        (
            "id" => null,
            "user_id" => $this->view->account->id,
            "location" => $location,
            "currency" => $currency,
            "price" => $price,
            "bedrooms" => $bedrooms,
            "bathrooms" => $bathrooms,
            "type" => $type,
            "name" => $event_name,
            "description" => $event_description,
            "privacy" => $privacy
        );

        $sql = "INSERT INTO events (user_id,
          location,
          currency,
          price,
          bedrooms,
          bathrooms,
          type,
          name,
          description,
          privacy,
          created,
          updated) VALUES (:user_id,
            :location,
            :currency,
            :price,
            :bedrooms,
            :bathrooms,
            :type,
            :name,
            :description,
            :privacy,
            NOW(),
            NOW())";

        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':user_id', $event['user_id'], PDO::PARAM_STR);
            $stmt->bindParam(':location', $event['location'], PDO::PARAM_STR);
            $stmt->bindParam(':currency', $event['currency'], PDO::PARAM_STR);
            $stmt->bindParam(':price', $event['price'], PDO::PARAM_STR);
            $stmt->bindParam(':bedrooms', $event['bedrooms'], PDO::PARAM_STR);
            $stmt->bindParam(':bathrooms', $event['bathrooms'], PDO::PARAM_STR);
            $stmt->bindParam(':type', $event['type'], PDO::PARAM_STR);
            $stmt->bindParam(':name', $event['name'], PDO::PARAM_STR);
            $stmt->bindParam(':description', $event['description'], PDO::PARAM_STR);
            $stmt->bindParam(':privacy', $event['privacy'], PDO::PARAM_STR);

            $stmt->execute();
            $event['id'] = $this->database->lastInsertId();
        }

        //
        //INSERT EVENT_DATES
        //
        foreach($dates as $date)
        {
            $sql = "INSERT INTO event_dates (event_id, date, start_time, end_time) VALUES (:event_id, :date, :start_time, :end_time)";
            if($stmt = $this->database->prepare($sql))
            {
                $stmt->bindParam(':event_id', $event['id'], PDO::PARAM_STR);
                $stmt->bindParam(':date', $date['date'], PDO::PARAM_STR);
                $stmt->bindParam(':start_time', $date['start_time'], PDO::PARAM_STR);
                $stmt->bindParam(':end_time', $date['end_time'], PDO::PARAM_STR);

                $stmt->execute();
            }
        }

        //
        //INSERT EVENT_KEYWORDS
        //
        foreach($tags as $tag)
        {
            $sql = "INSERT INTO event_keywords (event_id, tag) VALUES (:event_id, :tag)";
            if($stmt = $this->database->prepare($sql))
            {
                $stmt->bindParam(':event_id', $event['id'], PDO::PARAM_STR);
                $stmt->bindParam(':tag', $tag, PDO::PARAM_STR);

                $stmt->execute();
            }
        }

        //
        //INSERT IMAGES AND EVENT_IMAGES
        //
        $insertedImageId = null;
        foreach($images as $image)
        {
            $sql = "INSERT INTO images (href) VALUES (:href)";
            if($stmt = $this->database->prepare($sql))
            {
                $href = '/public/app_data/event_images/'.$image;
                $stmt->bindParam(':href', $href, PDO::PARAM_STR);

                $stmt->execute();
                $insertedImageId = $this->database->lastInsertId();
            }

            $sql = "INSERT INTO event_images (event_id, image_id) VALUES (:eid, :iid)";
            if($stmt = $this->database->prepare($sql))
            {
                $stmt->bindParam(':eid', $event['id'], PDO::PARAM_STR);
                $stmt->bindParam(':iid', $insertedImageId, PDO::PARAM_STR);

                $stmt->execute();
            }
        }

        $this->eventid = $event['id'];
    }

    //
    //Seaching
    //
    public function Search_POST()
    {
        //Get account info if logged in
        if(parent::IsUserLoggedIn())
        {
            parent::GetAccountInfo();
        }

        //Get Posted Variables
        $bedrooms = $_POST['bedrooms'];
        $type = $_POST['type'];
        $location = $_POST['location'];

        //
        //IMPORTANT!!!! Validation here
        //

        //Create query
        $params = array();

        $sql = "SELECT * FROM events";

        //bedrooms
        if($bedrooms != 'any')
        {
            $sql = "SELECT * FROM events WHERE bedrooms=:bedrooms";
            array_push($params, array('bind'=>':bedrooms', 'value'=>$bedrooms));
        }

        //type
        if($type != 'any')
        {
            if($bedrooms != 'any')
            {
                $sql = "SELECT * FROM events WHERE bedrooms=:bedrooms AND type=:type";
            }
            else
            {
                $sql = "SELECT * FROM events WHERE type=:type";
            }

            array_push($params, array('bind'=>':type', 'value'=>$type));
        }

        //location
        if($location != 'any')
        {
            if($bedrooms == 'any' && $type == 'any')
            {
                $sql ="SELECT * FROM events WHERE location=:location";
            }
            elseif($bedrooms != 'any' && $type == 'any')
            {
                $sql = "SELECT * FROM events WHERE bedrooms=:bedrooms AND location=:location";
            }
            elseif($bedrooms == 'any' && $type != 'any')
            {
                $sql = "SELECT * FROM events WHERE type=:type AND location=:location";
            }
            else
            {
                $sql = "SELECT * FROM events WHERE bedrooms=:bedrooms AND type=:type AND location=:location";
            }


            array_push($params, array('bind'=>':location', 'value'=>$location));
        }

//        echo '<pre>';
//        echo $sql.'<br>';
//        print_r($params);
//        exit();

        //Return results
        $this->view->events = parent::GetSearchResults($sql.' ORDER BY created DESC', $params);
        $this->view->selectedBedrooms = $bedrooms;
        $this->view->selectedType = $type;
        $this->view->selectedLocation = $location;

        //Get result tags, this is to prevent duplicate entries
        $resultTags = array();
        foreach($this->view->events as $event)
        {
            foreach($event['keywords'] as $keywords)
            {
                $tagFound = false;
                foreach($resultTags as $rt)
                {
                    if($keywords['tag'] == $rt)
                    {
                        $tagFound = true;
                    }
                }

                if(!$tagFound)
                {
                    array_push($resultTags, $keywords['tag']);
                }
            }

        }

        $this->view->resultsTags = $resultTags;

        //Get result dates, this is to prevent duplicate entries
        $resultDates = array();
        foreach($this->view->events as $event)
        {
            foreach($event['dates'] as $date)
            {
                $dateFound = false;
                foreach($resultDates as $rd)
                {
                    if($date['date'] == $rd)
                    {
                        $dateFound = true;
                    }
                }

                if(!$dateFound)
                {
                    array_push($resultDates, $date['date']);
                }
            }

        }

        $this->view->resultsDates = $resultDates;


        //print_r($this->view->resultsTags); exit();
    }
    public function Detail($id)
    {
        //Get account info if logged in
        if(parent::IsUserLoggedIn())
        {
            parent::GetAccountInfo();
        }

        $event = $this->GetById('events', $id);
        $this->view->event = $this->GetEventRelatedData($event);
        //echo '<pre>'; print_r($this->view->event);exit();

        $sql = "SELECT first_name, last_name, bio FROM users WHERE id=:user_id";
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':user_id', $this->view->event['user_id'], PDO::PARAM_STR);
            $stmt->execute();
            $this->view->event['user'] = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt->closeCursor();

        }
    }

    //
    //RSVP
    //
    public function RSVP_POST($id)
    {
        parent::GetAccountInfo();
        $eventDate = null;

        //Check if user has already rsvps
        $sql = "SELECT * FROM event_rsvps WHERE event_date_id=:event_date_id AND user_id=:user_id";
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':event_date_id', $id, PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $this->view->account->id, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if($row)
            {
                $return["json"] = "exists";
                echo json_encode($return);
                exit();
            }
        }

        $sql = "INSERT INTO event_rsvps (event_date_id, user_id, created, updated) VALUES (:event_date_id, :user_id, NOW(), NOW())";
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':event_date_id', $id, PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $this->view->account->id, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();

            $return["json"] = "success";
            echo json_encode($return);
            exit();
        }
    }
}