<?php

class HomeModel extends BaseModel
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

    public function Index()
    {
        //Get Events
        $sql = "SELECT * FROM events LIMIT 6";
        $this->view->events = parent::GetAllEventData($sql);
    }
}