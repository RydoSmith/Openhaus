<?php

class Home extends BaseController
{
    public function __construct($action, $urlParams)
    {
        parent::__construct($action, $urlParams);
    }

    protected function Index()
    {
        $model = new HomeModel("Index");
        $model->setPageTitle('Home');

        if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] == 1)
        {
            $model->GetAccountInfo();
        }

        $this->ReturnView($model->view);
    }
}