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

        $this->ReturnView($model->view);
    }
}