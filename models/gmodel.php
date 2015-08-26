<?php

class GModel extends BaseModel
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

    //IMPORTANT
    //Remove from live
    //IMPORTANT
    public function Run()
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
            "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Nullam mollis. Ut justo. Suspendisse potenti.",
            "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Nullam mollis. Ut justo. Suspendisse potenti.",
            "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Nullam mollis. Ut justo. Suspendisse potenti.",
            "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Nullam mollis. Ut justo. Suspendisse potenti.",
            "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Nullam mollis. Ut justo. Suspendisse potenti.",
            "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Nullam mollis. Ut justo. Suspendisse potenti.",
            "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Nullam mollis. Ut justo. Suspendisse potenti.",
            "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Nullam mollis. Ut justo. Suspendisse potenti.",
            "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Nullam mollis. Ut justo. Suspendisse potenti.",
            "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Nullam mollis. Ut justo. Suspendisse potenti."
        );

        $dates = array
        (
            array
            (
                'date'=>'2015-10-10',
                'start_time'=>'09:00:00',
                'end_time'=>'11:00:00'
            ),
            array
            (
                'date'=>'2015-10-10',
                'start_time'=>'09:00:00',
                'end_time'=>'11:00:00'
            ),
            array
            (
                'date'=>'2015-10-12',
                'start_time'=>'09:00:00',
                'end_time'=>'11:00:00'
            ),
            array
            (
                'date'=>'2015-10-13',
                'start_time'=>'09:00:00',
                'end_time'=>'11:00:00'
            ),
            array
            (
                'date'=>'2015-10-14',
                'start_time'=>'09:00:00',
                'end_time'=>'11:00:00'
            ),
            array
            (
                'date'=>'2015-10-15',
                'start_time'=>'09:00:00',
                'end_time'=>'11:00:00'
            ),
            array
            (
                'date'=>'2015-10-16',
                'start_time'=>'09:00:00',
                'end_time'=>'11:00:00'
            ),
            array
            (
                'date'=>'2015-10-18',
                'start_time'=>'09:00:00',
                'end_time'=>'11:00:00'
            ),
            array
            (
                'date'=>'2015-10-18',
                'start_time'=>'09:00:00',
                'end_time'=>'11:00:00'
            ),
            array
            (
                'date'=>'2015-10-18',
                'start_time'=>'09:00:00',
                'end_time'=>'11:00:00'
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
                'CAD',
                :price,
                :bedrooms,
                :bathrooms,
                :type,
                :name,
                :description,
                :privacy,
                NOW(),
                NOW()
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

            $sql = "INSERT INTO event_dates (event_id, date, start_time, end_time) VALUES (:event_id, :date, :start_time, :end_time)";
            if($stmt = $this->database->prepare($sql))
            {
                $stmt->bindParam(':event_id', $event_id, PDO::PARAM_STR);
                $stmt->bindParam(':date', $dates[rand(0, count($dates)-1)]['date'], PDO::PARAM_STR);
                $stmt->bindParam(':start_time', $dates[rand(0, count($dates)-1)]['start_time'], PDO::PARAM_STR);
                $stmt->bindParam(':end_time', $dates[rand(0, count($dates)-1)]['end_time'], PDO::PARAM_STR);

                $stmt->execute();
            }
            $sql = "INSERT INTO event_dates (event_id, date, start_time, end_time) VALUES (:event_id, :date, :start_time, :end_time)";
            if($stmt = $this->database->prepare($sql))
            {
                $stmt->bindParam(':event_id', $event_id, PDO::PARAM_STR);
                $stmt->bindParam(':date', $dates[rand(0, count($dates)-1)]['date'], PDO::PARAM_STR);
                $stmt->bindParam(':start_time', $dates[rand(0, count($dates)-1)]['start_time'], PDO::PARAM_STR);
                $stmt->bindParam(':end_time', $dates[rand(0, count($dates)-1)]['end_time'], PDO::PARAM_STR);

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
            for($i = 0; $i < 3; $i++)
            {
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