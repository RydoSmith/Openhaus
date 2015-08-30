<?php

class User extends BaseController
{
    public function __construct($action, $urlParams)
    {
        parent::__construct($action, $urlParams);
    }

    protected function Dashboard()
    {
        $model = new UserModel("Dashboard");
        $model->setPageTitle('Dashboard');

        //echo '<pre>'; print_r($model->view); exit();

        $this->ReturnView($model->view);
    }

    protected function DismissNotification()
    {
        $id = json_decode(file_get_contents('php://input'), true);
        $model = new UserModel("DismissNotification", true, array($id));
    }

    protected function GetUnSeenCount()
    {
        $model = new UserModel("GetUnSeenCount", true, array());
    }
}