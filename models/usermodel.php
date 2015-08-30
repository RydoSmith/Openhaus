<?php

class UserModel extends BaseModel
{
    public function __construct($action, $isPost = false, $params = array())
    {
        parent::__construct(include('conf/config.php'));
        if($isPost)
        {
            call_user_func_array(array($this, $action.'_POST'), $params);
        }
        else
        {
            call_user_func_array(array($this, $action), $params);
        }
    }

    public function Dashboard()
    {
        //Get Account Info
        parent::GetAccountInfo();

        //To DO
        //get notifications
    }

    public function MyEvents()
    {
        //Get Account Info
        parent::GetAccountInfo();


        //
        //Get Current events
        //
        //Get all user rsvps
        $rspvs = array();
        $sql = "SELECT * FROM event_rsvps WHERE user_id=:user_id";
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':user_id', $this->view->account->id, PDO::PARAM_STR);
            $stmt->execute();
            $rspvs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        //echo '<pre>'; print_r($rspvs); exit();
        //Get event ids from event dates
        $eventDates = array();
        foreach($rspvs as $rspv)
        {

            $sql = "SELECT * FROM event_dates WHERE id=:event_date_id AND date >= DATE(NOW())";
            if($stmt = $this->database->prepare($sql))
            {
                $stmt->bindParam(':event_date_id', $rspv['event_date_id'], PDO::PARAM_STR);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if($row)
                {
                    array_push($eventDates, $row);
                }

            }
        }

        //echo '<pre>'; print_r($eventDates); exit();


        //Get events
        $this->view->current_events = array();

        foreach($eventDates as $eventDate)
        {
            $event = $this->GetById('events', $eventDate['event_id']);
            $event['rspv_date'] = $eventDate;
            array_push($this->view->current_events, $this->GetEventRelatedData($event));
        }


        //
        //Get Past events
        //
        //Get all user rsvps
        $rspvs = array();
        $sql = "SELECT * FROM event_rsvps WHERE user_id=:user_id";
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':user_id', $this->view->account->id, PDO::PARAM_STR);
            $stmt->execute();
            $rspvs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        //echo '<pre>'; print_r($rspvs); exit();
        //Get event ids from event dates
        $eventDates = array();
        foreach($rspvs as $rspv)
        {

            $sql = "SELECT * FROM event_dates WHERE id=:event_date_id AND date < DATE(NOW())";
            if($stmt = $this->database->prepare($sql))
            {
                $stmt->bindParam(':event_date_id', $rspv['event_date_id'], PDO::PARAM_STR);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if($row)
                {
                    array_push($eventDates, $row);
                }

            }
        }

        //echo '<pre>'; print_r($eventDates); exit();


        //Get events
        $this->view->past_events = array();

        foreach($eventDates as $eventDate)
        {
            $event = $this->GetById('events', $eventDate['event_id']);
            $event['rspv_date'] = $eventDate;
            array_push($this->view->past_events, $this->GetEventRelatedData($event));
        }


    }

    public function MyListings()
    {
        //Get Account Info
        parent::GetAccountInfo();

        //
        //Get Current events
        //
        $this->view->current_events = array();

        //Get events by user id
        $events = array();
        $sql = "SELECT * FROM events WHERE user_id=:user_id";
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':user_id', $this->view->account->id, PDO::PARAM_STR);
            $stmt->execute();
            $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        //get event dates by event id
        $eventDates = array();
        foreach($events as $event)
        {
            //Get event dates
            $sql = "SELECT * FROM event_dates WHERE event_id=:event_id AND date >= DATE(NOW())";
            if($stmt = $this->database->prepare($sql))
            {
                $stmt->bindParam(':event_id', $event['id'], PDO::PARAM_STR);
                $stmt->execute();

                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if($row)
                {
                    array_push($eventDates, $row);
                }

            }
        }

        //Remove duplicates
        $eventDates = array_map("unserialize", array_unique(array_map("serialize", $eventDates)));
        //echo '<pre>'; print_r($eventDates); exit();

        foreach($eventDates as $eventDate)
        {
            $event = $this->GetById('events', $eventDate['event_id']);
            array_push($this->view->current_events, $this->GetEventRelatedData($event));
        }

        //
        //Get Previous events
        //
        $this->view->past_events = array();

        //Get events by user id
        $events = array();
        $sql = "SELECT * FROM events WHERE user_id=:user_id";
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':user_id', $this->view->account->id, PDO::PARAM_STR);
            $stmt->execute();
            $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        //get event dates by event id
        $eventDates = array();
        foreach($events as $event)
        {
            //Get event dates
            $sql = "SELECT * FROM event_dates WHERE event_id=:event_id AND date < DATE(NOW())";
            if($stmt = $this->database->prepare($sql))
            {
                $stmt->bindParam(':event_id', $event['id'], PDO::PARAM_STR);
                $stmt->execute();

                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if($row)
                {
                    array_push($eventDates, $row);
                }

            }
        }

        //Remove duplicates
        $eventDates = array_map("unserialize", array_unique(array_map("serialize", $eventDates)));
        //echo '<pre>'; print_r($eventDates); exit();

        foreach($eventDates as $eventDate)
        {
            $event = $this->GetById('events', $eventDate['event_id']);
            array_push($this->view->past_events, $this->GetEventRelatedData($event));
        }


    }

    public function WatchList()
    {
        //Get Account Info
        parent::GetAccountInfo();

        $sql = "SELECT * FROM watchlist WHERE user_id=:user_id";
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':user_id', $this->view->account->id, PDO::PARAM_STR);
            $stmt->execute();
            $this->view->watch_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        //echo '<pre>'; print_r($eventDates); exit();

        $this->view->events = array();
        foreach($this->view->watch_list as $watchlist)
        {
            $event = $this->GetById('events', $watchlist['event_id']);
            array_push($this->view->events, $this->GetEventRelatedData($event));
        }

    }

    public function Settings()
    {
        //Get Account Info
        parent::GetAccountInfo();

        //Get user
        $sql = "SELECT * FROM users WHERE id=:user_id LIMIT 1";
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':user_id', $this->view->account->id, PDO::PARAM_STR);
            $stmt->execute();
            $this->view->post = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        //get Countries
        $sql = "SELECT id, name FROM countries";
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->execute();
            $this->view->post['countries'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function Settings_POST()
    {
        //Get Account Info
        parent::GetAccountInfo();

        $this->view->post = array
        (
            'id'    =>  $_POST['id'],
            'email' =>  strtolower(trim($_POST['email'])),
            'username' => strtolower(trim($_POST['username'])),
            'first_name'  =>  strtolower(trim($_POST['first_name'])),
            'last_name'  =>  strtolower(trim($_POST['last_name'])),
            'birthday'  =>  $_POST['birthday'] ? date('Y-m-d', strtotime($_POST['birthday'])) : null,
            'bio'  =>  $_POST['bio'] ? strtolower(trim($_POST['bio'])) : null,
            'gender'  =>  $_POST['gender'] ? strtolower(trim($_POST['gender'])) : null,
            'country_id'  =>  $_POST['country_id'],
            'city'  =>  strtolower(trim($_POST['city']))
        );

        //Get countries to return in the event of error
        $sql = "SELECT id, name FROM countries";
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->execute();
            $this->view->post['countries'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        //
        //Validation
        //

        //Username
        if(!$this->view->post['username'])
        {
            $this->addModelError('username', new ModelError('Please enter a username'));
        }

        //First Name
        if(!$this->view->post['first_name'])
        {
            $this->addModelError('first_name', new ModelError('Please enter your first name'));
        }

        //First Name
        if(!$this->view->post['last_name'])
        {
            $this->addModelError('last_name', new ModelError('Please enter your last name'));
        }

        //Country
        if(!$this->view->post['country_id'])
        {
            $this->addModelError('country_id', new ModelError('Please select a country'));
        }

        //City
        if(!$this->view->post['city'])
        {
            $this->addModelError('city', new ModelError('Please enter your city'));
        }

        //Image
        if(!empty($_FILES['file']['name']))
        {
            if($_FILES['file']['type'] != 'image/jpeg' && $_FILES['file']['type'] != 'image/png' && $_FILES['file']['type'] != 'image/pjpeg')
            {
                $this->addModelError('image', new ModelError('Image must be a valid format, either .jpg or .png'));
            }

            if($_FILES['file']['size'] > 1048576)
            {
                $this->addModelError('image', new ModelError('File too large, must be smaller than 1mb'));
            }
        }

        if($this->hasError()) { return; }

        //
        //End validation
        //

        //
        //Update user
        //
        $sql = "UPDATE users
                SET
                  username=:username,
                  first_name=:first_name,
                  last_name=:last_name,
                  country_id=:country_id,
                  city=:city,
                  birthday=:birthday,
                  bio=:bio,
                  gender=:gender,
                  updated=NOW()
                WHERE id=:id";

        if($stmt = $this->database->prepare($sql)) {

            $stmt->bindParam(':username', $this->view->post['username'], PDO::PARAM_STR);
            $stmt->bindParam(':first_name', $this->view->post['first_name'], PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $this->view->post['last_name'], PDO::PARAM_STR);
            $stmt->bindParam(':country_id', $this->view->post['country_id'], PDO::PARAM_STR);
            $stmt->bindParam(':city', $this->view->post['city'], PDO::PARAM_STR);
            $stmt->bindParam(':city', $this->view->post['city'], PDO::PARAM_STR);
            $stmt->bindParam(':birthday', $this->view->post['birthday'], PDO::PARAM_STR);
            $stmt->bindParam(':bio', $this->view->post['bio'], PDO::PARAM_STR);
            $stmt->bindParam(':gender', $this->view->post['gender'], PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->view->post['id'], PDO::PARAM_STR);

            $stmt->execute();
            $stmt->closeCursor();
        }

        //
        //Save image
        //
        $newfilename = '';
        if (!empty($_FILES['file']['name']))
        {
            //Set server directory
            $storeFolder = '/var/www/public/app_data/user_images/';

            //make new filename
            $temp = explode(".", $_FILES["file"]["name"]);
            $newfilename = md5($this->view->post['email']) . '.' . end($temp);

            //Move image to user_images
            move_uploaded_file($_FILES["file"]["tmp_name"], $storeFolder . $newfilename);
        }
        else
        {
            //Set server directory
            $storeFolder = '/var/www/public/app_data/user_images/';

            //make new filename
            $newfilename = md5($this->view->post['email']) . '.png';

            //Move image to user_images
            copy('/var/www/public/img/default-avatar.png', $storeFolder . $newfilename);
        }

        //File moved, save to db
        $sql = "INSERT INTO user_images (user_id, href, created, updated) VALUES (:user_id, :href, NOW(), NOW())";
        if($stmt = $this->database->prepare($sql))
        {
            $href = '/public/app_data/user_images/'.$newfilename;

            $stmt->bindParam(':user_id', $this->view->post['id'], PDO::PARAM_STR);
            $stmt->bindParam(':href', $href, PDO::PARAM_STR);

            $stmt->execute();
        }
    }

    public function ChangePassword_POST()
    {
        //Get Account Info
        parent::GetAccountInfo();

        $this->view->post = array
        (
            'id' => $_POST['id'],
            'email' => strtolower(trim($_POST['email'])),
            'password' => $_POST['password'],
            'new_password' => $_POST['new_password'],
            'confirm_password' => $_POST['confirm_password']
        );

        //Get countries to return in the event of error
        $sql = "SELECT id, name FROM countries";
        if ($stmt = $this->database->prepare($sql)) {
            $stmt->execute();
            $this->view->post['countries'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        //
        //Validation
        //

        //Password
        if (!$this->view->post['password']) {
            $this->addModelError('password', new ModelError('Please enter your password'));
        }

        //New password
        if (!$this->view->post['new_password']) {
            $this->addModelError('new_password', new ModelError('Please enter a new password'));
        }

        //Confirm password
        if (!$this->view->post['confirm_password']) {
            $this->addModelError('confirm_password', new ModelError('Please confirm your password'));
        }

        if ($this->hasError()) {
            return;
        }

        //
        //End validation
        //

        //
        //Update user
        //
        $sql = "UPDATE users
                SET
                  password=SHA1(:new_password),
                  updated=NOW()
                WHERE id=:id";

        if ($stmt = $this->database->prepare($sql)) {

            $stmt->bindParam(':new_password', $this->view->post['new_password'], PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->view->post['id'], PDO::PARAM_STR);

            $stmt->execute();
            $stmt->closeCursor();
        }
    }

    //
    //Dismiss Notification
    //
    public function DismissNotification_POST($notification_id)
    {
        parent::GetAccountInfo();

        //Make sure logged in user is
        //owner of notification
        $sql = "SELECT created FROM notifications WHERE id=:notification_id AND user_id=:user_id LIMIT 1";
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':notification_id', $notification_id, PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $this->view->account->id, PDO::PARAM_STR);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!$row)
            {
                echo json_encode("failed");
                exit();
            }
        }


        $sql = "UPDATE notifications SET has_seen=1 WHERE id=:notification_id";
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':notification_id', $notification_id, PDO::PARAM_STR);
            $stmt->execute();

            $stmt->closeCursor();
            echo json_encode("success");
            exit();
        }
    }

    //
    //Dismiss Notification
    //
    public function GetUnSeenCount_POST()
    {
        parent::GetAccountInfo();
        $sql = "SELECT id FROM notifications WHERE user_id=:user_id AND has_seen=0";
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':user_id', $this->view->account->id, PDO::PARAM_STR);
            $stmt->execute();

            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(count($row));
            exit();
        }
    }


}