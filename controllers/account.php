<?php

class Account extends BaseController
{
    public function __construct($action, $urlParams)
    {
        parent::__construct($action, $urlParams);
    }

    protected function SignIn()
    {
        $model = new AccountModel("SignIn");
        $model->setPageTitle('Sign In');
        $this->ReturnView($model->view);
    }
}