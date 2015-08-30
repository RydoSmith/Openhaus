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

    protected function MyEvents()
    {
        $model = new UserModel("MyEvents");
        $model->setPageTitle('MyEvents');

        //echo '<pre>'; print_r($model->view); exit();

        $this->ReturnView($model->view);
    }

    protected function MyListings()
    {
        $model = new UserModel("MyListings");
        $model->setPageTitle('MyListings');

        //echo '<pre>'; print_r($model->view); exit();

        $this->ReturnView($model->view);
    }

    protected function WatchList()
    {
        $model = new UserModel("WatchList");
        $model->setPageTitle('WatchList');

        //echo '<pre>'; print_r($model->view); exit();

        $this->ReturnView($model->view);
    }

    protected function Settings()
    {
        //Check if is post
        if(CHelper::IsPost())
        {
            //POST
            $model = new UserModel("Settings", true);

            //Error checking
            if($model->hasError())
            {
                $model->setPageTitle('User Settings');
                $this->ReturnViewByName("settings", $model->view, "layout");
                exit();
            }

            $this->Redirect('user', 'settings');
        }
        else
        {
            $model = new UserModel("Settings");
            $model->setPageTitle('User Settings');

            //echo '<pre>'; print_r($model->view); exit();

            $this->ReturnView($model->view);
        }
    }

    protected function ChangePassword()
    {
        //Check if is post
        if(CHelper::IsPost())
        {
            //POST
            $model = new UserModel("ChangePassword", true);

            //Error checking
            if($model->hasError())
            {
                $model->setPageTitle('User Settings');
                $this->ReturnViewByName("settings", $model->view, "layout");
                exit();
            }

            $this->Redirect('user', 'settings');
        }
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