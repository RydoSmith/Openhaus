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
        //Check user is already logged in redirect to home
        if(CHelper::IsLoggedIn())
        {
            $this->Redirect('home');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            //POST
            $model = new AccountModel("SignUp", true);

            //Error checking
            if($model->hasError())
            {
                $model->setPageTitle('Sign Up');
                $this->ReturnViewByName("signup", $model->view);
                exit();
            }

//            $model->setMesssage(MessageType::Success, 'Success! ', 'Welcome, please check your email and follow the instructions to complete the registration process.');
            $model->setPageTitle('Sign Up');

            $this->ReturnViewByName("welcome", $model->view);
        }
        else
        {
            //GET
            $model = new AccountModel("SignUp");

            $model->setPageTitle('Sign Up');
            $this->ReturnViewByName("signup", $model->view);
        }
    }

    /* VERIFY */
    protected function Verify($v, $e)
    {
        $model = new AccountModel("Verify", false, $this->urlParams);
        $model->setPageTitle("Account Verified");
        $this->ReturnView($model->view);
    }

    /* COMPLETE SIGN UP */
    protected function Complete()
    {
        $params = array
        (
            'id'    =>  $_POST['id'],
            'email' =>  $_POST['email'],
            'username' => $_POST['username'],
            'password'  =>  $_POST['password'],
            'confirm_password' => $_POST['confirm_password'],
            'first_name'  =>  $_POST['first_name'],
            'last_name'  =>  $_POST['last_name'],
            'country_id'  =>  $_POST['country_id'],
            'city'  =>  $_POST['city']

        );

        $model = new AccountModel("Complete", true, $params);

        //Error checking
        if($model->hasError())
        {
            //Model has errors, add params to model to repopulate form
            $model->view->id = $params['id'];
            $model->view->email = isset($params['email']) ? $params['email'] : null;
            $model->view->username = isset($params['username']) ? $params['username'] : null;
            $model->view->first_name = isset($params['first_name']) ? $params['first_name'] : null;
            $model->view->last_name = isset($params['last_name']) ? $params['last_name'] : null;
            $model->view->country_id = isset($params['country_id']) ? $params['country_id'] : null;
            $model->view->city = isset($params['city']) ? $params['city'] : null;

            $model->setPageTitle("Account Verified");
            $this->ReturnViewByName('verify', $model->view);
            exit();
        }

        $model->setPageTitle("Complete Registration");

        //Login
        $_SESSION['Username'] = $_POST['email'];
        $_SESSION['LoggedIn'] = 1;

        //ACCOUNT COMPLETION: Redirect to home
        $this->Redirect('home');
    }

    /* LOGIN */
    protected function Login($params = null)
    {
        //Check user is already logged in redirect to home
        if(CHelper::IsLoggedIn())
        {
            $this->Redirect('home');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            //POST
            $model = new AccountModel("Login", true);

            //Error checking
            if($model->hasError())
            {
                $model->setPageTitle('Login');
                $this->ReturnViewByName("login", $model->view);
                exit();
            }

            //See if a return url has been set
            if(isset($_POST['returnUrl']))
            {
                switch($_POST['returnUrl'])
                {
                    case '/event/create':
                        $this->Redirect('event', 'create');
                        break;
                }
            }
            else
            {
                //No return parameter send to default logged in screen
                $this->Redirect('home');
            }
        }
        else
        {
            //GET
            $model = new AccountModel("Login");

            //Set the return url based on the passed parameters
            if(isset($params))
            {
                switch($params)
                {
                    case 'createevent':
                        $model->view->returnUrl = '/event/create';
                        break;
                }
            }

            $model->setPageTitle('Login');
            $this->ReturnViewByName("login", $model->view);
        }
    }

    /* LOGOUT */
    protected function Logout()
    {
        // Unset all of the session variables.
        $_SESSION = array();

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies"))
        {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();
        header('Location: /');
        $this->Redirect('home');
    }

    /* PASSWORD RESET */
    protected function Password()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            //POST
            $model = new AccountModel("Password", true);

            //Error checking
            if($model->hasError())
            {
                //Model has errors return values for display
                $model->view->email = isset($_POST['email']) ? $_POST['email'] : null;

                $model->setPageTitle('Forgot Password');
                $this->ReturnViewByName("password", $model->view);
                exit();
            }

            $model->setPageTitle('Password Reset');
            $this->ReturnViewByName("passwordreset", $model->view);
        }
        else
        {
            //GET
            $model = new AccountModel("Password");

            $model->setPageTitle('Reset Password');
            $this->ReturnViewByName('password', $model->view);
        }
    }
    protected function ResetPassword($v = '', $e = '')
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            //POST
            $model = new AccountModel("ResetPassword", true);

            //Error checking
            if($model->hasError())
            {
                //Model has errors, add params to model to repopulate form
                $model->view->id = $_POST['id'];
                $model->view->email = $_POST['email'];

                $model->setPageTitle("Password Reset");
                $this->ReturnViewByName('resetpassword', $model->view);
                exit();
            }

            $this->ReturnViewByName('login', $model->view);
        }
        else
        {
            //GET
            $model = new AccountModel("ResetPassword", false, $this->urlParams);

            $model->setPageTitle("Reset Password");
            $this->ReturnView($model->view);
        }
    }


}