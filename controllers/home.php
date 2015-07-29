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
        $this->ReturnView($model->view);
    }

    protected function About()
    {
        $model = new HomeModel("About");
        $model->setPageTitle('About');
        $this->ReturnView($model->view);
    }
}