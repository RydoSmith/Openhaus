<?php

class Account extends BaseController
{
    public function __construct($action, $urlParams)
    {
        parent::__construct($action, $urlParams);
    }

    protected function SignUp()
    {
        $model = new AccountModel("SignUp");
        $model->setPageTitle('Sign Up');
        $this->ReturnView($model->view, "layout_no_header");
    }

    protected function Login()
    {
        $model = new AccountModel("Login");
        $model->setPageTitle('Login');
        $this->ReturnView($model->view, "layout_no_header");
    }
}