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
        $this->view->post = array
        (
            'location' => strtolower(trim($_POST['location'])),
            'currency' => $_POST['currency'],
            'price'  => trim($_POST['price']),
            'bedrooms' => $_POST['bedrooms'],
            'bathrooms' => $_POST['bathrooms'],
            'type' => $_POST['type'],
            'tags' => $_POST['tags'],
            'images' => $_POST['images'],
            'name' => strtolower(trim($_POST['name'])),
            'description' => strtolower(trim($_POST['description'])),
            'privacy' => $_POST['privacy']
        );

        //Get Dates and Times and convert to MySQL Date and Time format
        $this->view->post['dates'] = array(); //[array[date, time]]
        for($i = 0; $i < count($_POST['dates']); $i++)
        {
            $parts = explode('-', $_POST['dates'][$i]);
            $tmp = array
            (
                'date' => date('Y-m-d', strtotime(str_replace('-', '/', $parts[0]))),
                'start_time' => date('H:i:s', strtotime($parts[1])),
                'end_time' => date('H:i:s', strtotime($parts[2]))
             );
            array_push($this->view->post['dates'], $tmp);
        }

        //echo '<pre>'; print_r($this->view->post); exit();

        //
        //Validation
        //
//        if($this->view->post['location'])
//        {
//            $this->addModelError('location', new ModelError('Location is required'));
//        }
//
//        if(is_numeric($this->view->post['location']))
//        {
//            $this->addModelError('price', new ModelError('Not a valid number'));
//        }
//
//        if($this->view->post['name'])
//        {
//            $this->addModelError('name', new ModelError('Name is required'));
//        }
//
//        if($this->view->post['description'])
//        {
//            $this->addModelError('description', new ModelError('Description is required'));
//        }
//
//        if($this->hasError()){ return; }
        //
        //End Validation
        //

        //
        //Insert Event
        //
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
            $stmt->bindParam(':user_id', $this->view->account->id, PDO::PARAM_STR);
            $stmt->bindParam(':location', $this->view->post['location'], PDO::PARAM_STR);
            $stmt->bindParam(':currency', $this->view->post['currency'], PDO::PARAM_STR);
            $stmt->bindParam(':price', $this->view->post['price'], PDO::PARAM_STR);
            $stmt->bindParam(':bedrooms', $this->view->post['bedrooms'], PDO::PARAM_STR);
            $stmt->bindParam(':bathrooms', $this->view->post['bathrooms'], PDO::PARAM_STR);
            $stmt->bindParam(':type', $this->view->post['type'], PDO::PARAM_STR);
            $stmt->bindParam(':name', $this->view->post['name'], PDO::PARAM_STR);
            $stmt->bindParam(':description', $this->view->post['description'], PDO::PARAM_STR);
            $stmt->bindParam(':privacy', $this->view->post['privacy'], PDO::PARAM_STR);

            $stmt->execute();
            $this->view->post['id'] = $this->database->lastInsertId();
        }

        //
        //Insert event dates
        //
        foreach($this->view->post['dates'] as $date)
        {
            $sql = "INSERT INTO event_dates (event_id, date, start_time, end_time, created, updated) VALUES (:event_id, :date, :start_time, :end_time, NOW(), NOW())";
            if($stmt = $this->database->prepare($sql))
            {
                $stmt->bindParam(':event_id', $this->view->post['id'], PDO::PARAM_STR);
                $stmt->bindParam(':date', $date['date'], PDO::PARAM_STR);
                $stmt->bindParam(':start_time', $date['start_time'], PDO::PARAM_STR);
                $stmt->bindParam(':end_time', $date['end_time'], PDO::PARAM_STR);

                $stmt->execute();
            }
        }

        //
        //Insert event keywords
        //
        foreach($this->view->post['tags'] as $tag)
        {
            $sql = "INSERT INTO event_keywords (event_id, tag, created, updated) VALUES (:event_id, :tag, NOW(), NOW())";
            if($stmt = $this->database->prepare($sql))
            {
                $stmt->bindParam(':event_id', $this->view->post['id'], PDO::PARAM_STR);
                $stmt->bindParam(':tag', $tag, PDO::PARAM_STR);

                $stmt->execute();
            }
        }

        //
        //Insert event images
        //
        $insertedImageId = null;
        foreach($this->view->post['images'] as $image)
        {
            $sql = "INSERT INTO event_images (event_id, href, created, updated) VALUES (:event_id, :href, NOW(), NOW())";
            if($stmt = $this->database->prepare($sql))
            {
                $href = '/public/app_data/event_images/'.$image;
                $stmt->bindParam(':event_id', $this->view->post['id'], PDO::PARAM_STR);
                $stmt->bindParam(':href', $href, PDO::PARAM_STR);

                $stmt->execute();
            }
        }
    }

    //
    //Seaching
    //
    public function Search($bedrooms, $type, $location)
    {

        //Get account info if logged in
        if(parent::IsUserLoggedIn())
        {
            parent::GetAccountInfo();
        }

        //Get Posted Variables
        $bedrooms = $bedrooms[1];
        $type = $type[1];
        $location = $location[1];

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

        $sql = "SELECT * FROM user_images WHERE user_id=:user_id";
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':user_id', $this->view->event['user_id'], PDO::PARAM_STR);
            $stmt->execute();
            $this->view->event['user']['image'] = $stmt->fetch(PDO::FETCH_ASSOC);

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

        $this->notification = array();

        //Get event id
        $sql = "SELECT event_id FROM event_dates WHERE id=:id LIMIT 1";
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->notification['event_id'] = $row['event_id'];
        }

        //Get event users id
        $sql = "SELECT user_id FROM events WHERE id=:event_id LIMIT 1";
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':event_id', $this->notification['event_id'], PDO::PARAM_STR);
            $stmt->execute();
            $row =  $stmt->fetch(PDO::FETCH_ASSOC);
            $this->notification['user_id'] = $row['user_id'];
        }

        $sql = "INSERT INTO event_rsvps (event_date_id, user_id, created, updated) VALUES (:event_date_id, :user_id, NOW(), NOW())";
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':event_date_id', $id, PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $this->view->account->id, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();

            //Create notification
            $notification = array
            (
                "user_id"=>$this->notification['user_id'],
                "type"=>NotificationType::RSVP,
                "title"=>NotificationType::RSVP,
                "content"=>" You have a new rsvp from ".$this->view->account->full_name
            );

            parent::AddNotification($notification);

            $return["json"] = "success";
            echo json_encode($return);
            exit();
        }


    }

    //
    //Comments
    //
    public function Comment_POST($event_id, $user_id, $comment)
    {
        parent::GetAccountInfo();

        $sql = "INSERT INTO event_comments (event_id, user_id, content, created, updated) VALUES (:event_id, :user_id, :content, NOW(), NOW())";
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':event_id', $event_id, PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
            $stmt->bindParam(':content', $comment, PDO::PARAM_STR);
            $stmt->execute();

            $stmt->closeCursor();

            $this->notification = array();
            //Get event users id
            $sql = "SELECT user_id FROM events WHERE id=:event_id LIMIT 1";
            if($stmt = $this->database->prepare($sql))
            {
                $stmt->bindParam(':event_id', $event_id, PDO::PARAM_STR);
                $stmt->execute();
                $row =  $stmt->fetch(PDO::FETCH_ASSOC);
                $this->notification['user_id'] = $row['user_id'];
            }

            //Create notification
            $notification = array
            (
                "user_id" => $this->notification['user_id'],
                "type" => NotificationType::CreatedComment,
                "title" => NotificationType::CreatedComment,
                "content" => 'You have a new <a href=/event/detail/'.$event_id.'#comments>comment</a> from '.$this->view->account->full_name
            );

            parent::AddNotification($notification);

            echo json_encode("success");
            exit();
        }
    }
}