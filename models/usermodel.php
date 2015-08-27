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
}