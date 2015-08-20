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
        $this->view->events = parent::GetAllEventData($sql, $params);
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

    public function GenerateSampleData()
    {
        parent::GetAccountInfo();

        $sampleKeywords = array
        (
            'cosy',
            'rustic',
            'modern',
            'old',
            'quiet',
            'refurbished',
            'farm',
            'peaceful',
            'zen',
            'rural',
            'original',
            'big',
            'small'
        );

        $count = 10;
        $sampleEvents = array();

        //locations
        $locations = array
        (
            '43 Main Street, Toronto, Canada, CA12 EFJ',
            '21 Some Road, Toronto, Canada, CA12 7ET',
            '828 Big Close, Toronto, Canada, CA12 5JD',
            '18 Small Lane, Toronto, Canada, CA12 9DJ',
            '98 Barvas Walk, Toronto, Canada, CA12 3DF',
            '23 Stronsey Drive, Toronto, Canada, CA12 9DN',
            '39 Kincorth Avenue, Toronto, Canada, CA12 2JF',
            '4339 Union Street, Toronto, Canada, CA12 2ED',
            '323 Tarrensay Square, Toronto, Canada, CA12 6FN',
            '849 MadeUp Road, Toronto, Canada, CA12 8FJ'
        );
        //names
        $names = array
        (
            'Event Sample Name #1',
            'Event Sample Name #2',
            'Event Sample Name #3',
            'Event Sample Name #4',
            'Event Sample Name #5',
            'Event Sample Name #6',
            'Event Sample Name #7',
            'Event Sample Name #8',
            'Event Sample Name #9',
            'Event Sample Name #10'
        );
        //descriptions
        $descriptions = array
        (
            "This is an awesome description for event #1, don't worry it's just sample data. Once we start populating the database this will look much nicer!",
            "This is an awesome description for event #2, don't worry it's just sample data. Once we start populating the database this will look much nicer!",
            "This is an awesome description for event #3, don't worry it's just sample data. Once we start populating the database this will look much nicer!",
            "This is an awesome description for event #4, don't worry it's just sample data. Once we start populating the database this will look much nicer!",
            "This is an awesome description for event #5, don't worry it's just sample data. Once we start populating the database this will look much nicer!",
            "This is an awesome description for event #6, don't worry it's just sample data. Once we start populating the database this will look much nicer!",
            "This is an awesome description for event #7, don't worry it's just sample data. Once we start populating the database this will look much nicer!",
            "This is an awesome description for event #8, don't worry it's just sample data. Once we start populating the database this will look much nicer!",
            "This is an awesome description for event #9, don't worry it's just sample data. Once we start populating the database this will look much nicer!",
            "This is an awesome description for event #10, don't worry it's just sample data. Once we start populating the database this will look much nicer!",
        );

        $dates = array
        (
            array
            (
                'date'=>'2015-10-10',
                'time'=>'09:00:00'
            ),
            array
            (
                'date'=>'2015-10-10',
                'time'=>'09:00:00'
            ),
            array
            (
                'date'=>'2015-10-12',
                'time'=>'09:00:00'
            ),
            array
            (
                'date'=>'2015-10-13',
                'time'=>'09:00:00'
            ),
            array
            (
                'date'=>'2015-10-14',
                'time'=>'09:00:00'
            ),
            array
            (
                'date'=>'2015-10-15',
                'time'=>'09:00:00'
            ),
            array
            (
                'date'=>'2015-10-16',
                'time'=>'09:00:00'
            ),
            array
            (
                'date'=>'2015-10-18',
                'time'=>'09:00:00'
            ),
            array
            (
                'date'=>'2015-10-18',
                'time'=>'09:00:00'
            ),
            array
            (
                'date'=>'2015-10-18',
                'time'=>'09:00:00'
            ),
        );

        //Generate sample events
        for($i = 0; $i < $count; $i++)
        {
            array_push($sampleEvents, $this->CreateSampleEvent($locations[$i], $names[$i], $descriptions[$i]));
        }

        //echo '<pre>'; print_r($sampleEvents); exit();

        $count = 0;
        $event_id = null;
        $insertedImageId = null;
        //Create events
        foreach($sampleEvents as $event)
        {
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
                :privacy
            )";

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

                $event_id = $this->database->lastInsertId();
            }

            $sql = "INSERT INTO event_dates (event_id, date, time) VALUES (:event_id, :date, :time)";
            if($stmt = $this->database->prepare($sql))
            {
                $stmt->bindParam(':event_id', $event_id, PDO::PARAM_STR);
                $stmt->bindParam(':date', $dates[$count]['date'], PDO::PARAM_STR);
                $stmt->bindParam(':time', $dates[$count]['time'], PDO::PARAM_STR);

                $stmt->execute();
            }
            $sql = "INSERT INTO event_dates (event_id, date, time) VALUES (:event_id, :date, :time)";
            if($stmt = $this->database->prepare($sql))
            {
                $stmt->bindParam(':event_id', $event_id, PDO::PARAM_STR);
                $stmt->bindParam(':date', $dates[rand(0, count($dates)-1)]['date'], PDO::PARAM_STR);
                $stmt->bindParam(':time', $dates[rand(0, count($dates)-1)]['time'], PDO::PARAM_STR);

                $stmt->execute();
            }

            //
            //INSERT EVENT_KEYWORDS
            //
            $sql = "INSERT INTO event_keywords (event_id, tag) VALUES (:event_id, :tag)";
            if($stmt = $this->database->prepare($sql))
            {
                $stmt->bindParam(':event_id', $event_id, PDO::PARAM_STR);
                $stmt->bindParam(':tag', $sampleKeywords[rand(0, count($sampleKeywords)-1)], PDO::PARAM_STR);

                $stmt->execute();
            }
            if($stmt = $this->database->prepare($sql))
            {
                $stmt->bindParam(':event_id', $event_id, PDO::PARAM_STR);
                $stmt->bindParam(':tag', $sampleKeywords[rand(0, count($sampleKeywords)-1)], PDO::PARAM_STR);

                $stmt->execute();
            }
            if($stmt = $this->database->prepare($sql))
            {
                $stmt->bindParam(':event_id', $event_id, PDO::PARAM_STR);
                $stmt->bindParam(':tag', $sampleKeywords[rand(0, count($sampleKeywords)-1)], PDO::PARAM_STR);

                $stmt->execute();
            }


            //
            //INSERT IMAGES AND EVENT_IMAGES
            //
            $image = rand(1, 3).'.jpg';
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
                $stmt->bindParam(':eid', $event_id, PDO::PARAM_STR);
                $stmt->bindParam(':iid', $insertedImageId, PDO::PARAM_STR);

                $stmt->execute();
            }

            $count++;
        }

    }

    public function CreateSampleEvent($location, $name, $description)
    {
        $types = array
        (
            'house',
            'condo',
            'townhouse',
            'other'
        );

        $prices = array
        (
            '89000',
            '98343',
            '101203',
            '103495',
            '105493',
            '118234',
            '117234',
            '121344',
            '128323',
            '134343',
            '142344',
            '145233',
            '146343',
            '157544',
            '190433',
            '204343',
            '267545',
            '356565',
            '405455'
        );

        return array
        (
            'user_id'=>$this->view->account->id,
            'location'=>$location,
            'price'=> $prices[rand(0, count($prices)-1)],
            'bedrooms'=> rand(1, 6),
            'bathrooms'=> rand(1, 6),
            'type'=>$types[rand(0, count($types)-1)],
            'name'=>$name,
            'description'=>$description,
            'privacy'=>'public'
        );
    }

}