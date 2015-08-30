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