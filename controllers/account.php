<?php

class Account extends BaseController
{
    public function __construct($action, $urlParams)
    {
        parent::__construct($action, $urlParams);
    }

    /* SIGN UP */
    protected function SignUp()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            //POST
            $model = new AccountModel("SignUp", true);

            //Error checking
            if($model->hasError())
            {
                $model->setPageTitle('Sign Up');
                $this->ReturnViewByName("signup", $model->view, 'layout_no_header');
                exit();
            }

//            $model->setMesssage(MessageType::Success, 'Success! ', 'Welcome, please check your email and follow the instructions to complete the registration process.');
            $model->setPageTitle('Sign Up');

            $this->ReturnViewByName("welcome", $model->view, 'layout_no_header');
        }
        else
        {
            //GET
            $model = new AccountModel("SignUp");

            $model->setPageTitle('Sign Up');
            $this->ReturnViewByName("signup", $model->view, 'layout_no_header');
        }
    }

    /* VERIFY */
    protected function Verify($v, $e)
    {
        $model = new AccountModel("Verify", false, $this->urlParams);
        $model->setPageTitle("Account Verified");
        $this->ReturnView($model->view, 'layout_no_header');
    }

    /* COMPLETE SIGN UP */
    protected function Complete()
    {
        $params = array
        (
            'id'    =>  $_POST['id'],
            'email' =>  $_POST['email'],
            'first_name'  =>  $_POST['first_name'],
            'last_name'  =>  $_POST['last_name'],
            'password'  =>  $_POST['password'],
            'confirm_password' => $_POST['confirm_password']
        );

        $model = new AccountModel("Complete", true, $params);

        //Error checking
        if($model->hasError())
        {
            //Model has errors, add params to model to repopulate form
            $model->view->id = $params['id'];
            $model->view->email = isset($params['email']) ? $params['email'] : null;
            $model->view->first_name = isset($params['first_name']) ? $params['first_name'] : null;
            $model->view->last_name = isset($params['last_name']) ? $params['last_name'] : null;

            $model->setPageTitle("Account Verified");
            $this->ReturnViewByName('verify', $model->view, 'layout');
            exit();
        }

        $model->setPageTitle("Complete Registration");
        $model->setMesssage(MessageType::Success, 'Account Set Up Complete ', 'Signed in as, '.$_POST['email'].'!');

        //Login
        $_SESSION['Username'] = $_POST['email'];
        $_SESSION['LoggedIn'] = 1;

        //ACCOUNT COMPLETION: Redirect to home
        $this->Redirect('home');
    }

    protected function Login()
    {
        $model = new AccountModel("Login");
        $model->setPageTitle('Login');
        $this->ReturnView($model->view, "layout_no_header");
    }
}