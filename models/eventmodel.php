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
                'time' => date('H:i:s', strtotime($parts[1]))
             );
        }

        $location = $_POST['location'];
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
          price,
          bedrooms,
          bathrooms,
          type,
          name,
          description,
          privacy) VALUES (:user_id,
            :location,
            :price,
            :bedrooms,
            :bathrooms,
            :type,
            :name,
            :description,
            :privacy)";

        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':user_id', $event['user_id'], PDO::PARAM_STR);
            $stmt->bindParam(':location', $event['location'], PDO::PARAM_STR);
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
            $sql = "INSERT INTO event_dates (event_id, date, time) VALUES (:event_id, :date, :time)";
            if($stmt = $this->database->prepare($sql))
            {
                $stmt->bindParam(':event_id', $event['id'], PDO::PARAM_STR);
                $stmt->bindParam(':date', $date['date'], PDO::PARAM_STR);
                $stmt->bindParam(':time', $date['time'], PDO::PARAM_STR);

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
}