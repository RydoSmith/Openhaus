<?php

class AccountModel extends BaseModel
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

    /* SIGN UP */
    public function SignUp()
    {

    }
    public function SignUp_POST()
    {
        $this->view->post = array
        (
            'email' => trim($_POST['email']),
            'verification_code' => sha1(time())
        );

        //
        //Validation
        //

        //Email
        if(!$this->view->post['email'])
        {
            $this->addModelError('email', new ModelError('Email address is required'));
            return;
        }

        //Check if email exists in database
        //if they do, return an error
        $sql = "SELECT COUNT(email) AS theCount FROM users WHERE email=:email";
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':email', $this->view->post['email'], PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch();

            //Check if email exists
            if($row['theCount'] != 0)
            {
                $this->addModelError('email', new ModelError('This email address already exists.'));
                return;
            }
            $stmt->closeCursor();
        }

        //
        //Send verification email
        //
        if(!$this->sendVerificationEmail($this->view->post['email'], $this->view->post['verification_code']))
        {
            $this->addModelError('email', new ModelError('There was a problem sending the email.'));
            return;
        }

        //
        //Insert user into database
        //
        $sql = "INSERT INTO users(email, verification_code) VALUES (:email, :verification_code)";

        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':email', $this->view->post['email'], PDO::PARAM_STR);
            $stmt->bindParam(':verification_code', $this->view->post['verification_code'], PDO::PARAM_STR);

            $stmt->execute();
            $stmt->closeCursor();
        }
    }

    //
    //Verify email and complete sign up
    //
    public function Verify($v, $e)
    {
        $sql = "SELECT *
          FROM users
          WHERE verification_code=:verification_code
          AND SHA1(email)=:email
          AND is_verified=0 LIMIT 1";

        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':verification_code', $v, PDO::PARAM_STR);
            $stmt->bindParam(':email', $e, PDO::PARAM_STR);

            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //echo '<pre>'; print_r($row); exit();

            if(isset($row['email']))
            {
                $this->view->post = array
                (
                    'id' => $row['id'],
                    'email' => $row['email']
                );
            }
        }

        $sql = "SELECT id, name FROM countries";
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->execute();
            $this->view->post['countries'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        //echo '<pre>'; print_r($this->view->post); exit();

    }
    public function Verify_POST()
    {
        //echo '<pre>'; print_r($_POST); exit();

        $this->view->post = array
        (
            'id'    =>  $_POST['id'],
            'email' =>  strtolower(trim($_POST['email'])),
            'username' => strtolower(trim($_POST['username'])),
            'password'  =>  strtolower(trim($_POST['password'])),
            'confirm_password' => strtolower(trim($_POST['confirm_password'])),
            'first_name'  =>  strtolower(trim($_POST['first_name'])),
            'last_name'  =>  strtolower(trim($_POST['last_name'])),
            'country_id'  =>  isset($_POST['country_id']) ? $_POST['country_id'] : null,
            'city'  =>  strtolower(trim($_POST['city']))
        );

        //Get countries to return in the event of error
        $sql = "SELECT id, name FROM countries";
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->execute();
            $this->view->post['countries'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        //
        //Validation
        //

        //Username
        if(!$this->view->post['username'])
        {
            $this->addModelError('username', new ModelError('Please enter a username'));
        }

        //Password
        if(!$this->view->post['password'])
        {
            $this->addModelError('password', new ModelError('Please enter your password'));
        }
        if(strlen($this->view->post['password']) < 8)
        {
            $this->addModelError('password', new ModelError('Password must be at least 8 characters'));
        }
        if($this->view->post['password'] != $this->view->post['confirm_password'])
        {
            $this->addModelError('confirm_password', new ModelError('Password do not match'));
        }

        //First Name
        if(!$this->view->post['first_name'])
        {
            $this->addModelError('first_name', new ModelError('Please enter your first name'));
        }

        //First Name
        if(!$this->view->post['last_name'])
        {
            $this->addModelError('last_name', new ModelError('Please enter your last name'));
        }

        //Country
        if(!$this->view->post['country_id'])
        {
            $this->addModelError('country_id', new ModelError('Please select a country'));
        }

        //City
        if(!$this->view->post['city'])
        {
            $this->addModelError('city', new ModelError('Please enter your city'));
        }

        //Image
        if(!empty($_FILES['file']['name']))
        {
            if($_FILES['file']['type'] != 'image/jpeg' && $_FILES['file']['type'] != 'image/png' && $_FILES['file']['type'] != 'image/pjpeg')
            {
                $this->addModelError('image', new ModelError('Image must be a valid format, either .jpg or .png'));
            }

            if($_FILES['file']['size'] > 10000)
            {
                $this->addModelError('image', new ModelError('File too large, must be smaller than 1mb'));
            }
        }

        if($this->hasError()) { return; }

        //
        //End validation
        //

        //
        //Update user
        //
        $sql = "UPDATE users
                SET
                  username=:username,
                  password=SHA1(:password),
                  first_name=:first_name,
                  last_name=:last_name,
                  country_id=:country_id,
                  city=:city,
                  is_complete=1,
                  is_verified=1,
                  created=NOW(),
                  updated=NOW()
                WHERE id=:id";

        if($stmt = $this->database->prepare($sql)) {

            $stmt->bindParam(':username', $this->view->post['username'], PDO::PARAM_STR);
            $stmt->bindParam(':password', $this->view->post['password'], PDO::PARAM_STR);
            $stmt->bindParam(':first_name', $this->view->post['first_name'], PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $this->view->post['last_name'], PDO::PARAM_STR);
            $stmt->bindParam(':country_id', $this->view->post['country_id'], PDO::PARAM_STR);
            $stmt->bindParam(':city', $this->view->post['city'], PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->view->post['id'], PDO::PARAM_STR);

            $stmt->execute();
            $stmt->closeCursor();
        }

        //
        //Save image
        //
        $newfilename = '';
        if (!empty($_FILES['file']['name']))
        {
            //Set server directory
            $storeFolder = '/var/www/public/app_data/user_images/';

            //make new filename
            $temp = explode(".", $_FILES["file"]["name"]);
            $newfilename = md5($this->view->post['email']) . '.' . end($temp);

            //Move image to user_images
            move_uploaded_file($_FILES["file"]["tmp_name"], $storeFolder . $newfilename);
        }
        else
        {
            //Set server directory
            $storeFolder = '/var/www/public/app_data/user_images/';

            //make new filename
            $newfilename = md5($this->view->post['email']) . '.png';

            //Move image to user_images
            copy('/var/www/public/img/default-avatar.png', $storeFolder . $newfilename);
        }

        //File moved, save to db
        $sql = "INSERT INTO user_images (user_id, href, created, updated) VALUES (:user_id, :href, NOW(), NOW())";
        if($stmt = $this->database->prepare($sql))
        {
            $href = '/public/app_data/user_images/'.$newfilename;

            $stmt->bindParam(':user_id', $this->view->post['id'], PDO::PARAM_STR);
            $stmt->bindParam(':href', $href, PDO::PARAM_STR);

            $stmt->execute();
        }
    }


    public function Login()
    {

    }
    public function Login_POST()
    {
        $e = $_POST['email'];
        $p = $_POST['password'];

        //MODEL VALIDATION
        if(!isset($e) || $e == '')
        {
            $this->addModelError('email', new ModelError('Email address is required.'));
            return;
        }

        if(!isset($p) || $p == '')
        {
            $this->addModelError('password', new ModelError('Password is required.'));
            return;
        }

        //Check if account is not verified
        $sql = 'SELECT COUNT(email) AS theCount FROM users WHERE email=:e AND is_verified = 0';
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':e', $e, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch();

            if($row['theCount'] == 1)
            {
                $this->addModelError('error', new ModelError('Account not verified. <a href="/account/resendvalidationemail">Resend email</a>?.'));
                return;
            }
        }

        //Check if account is pending password reset
        $sql = 'SELECT COUNT(email) AS theCount FROM users WHERE email=:e AND is_pending_password_reset = 1';
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':e', $e, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch();

            if($row['theCount'] == 1)
            {
                $this->addModelError('error', new ModelError('Pending password reset. <a href="/account/resendpasswordreset">Resend email</a>?.'));
                return;
            }
        }

        $sql = 'SELECT password FROM users WHERE email=:e';
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':e', $e, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch();

            if($row['password'] != sha1($p))
            {
                $this->addModelError('error', new ModelError('Incorrect details. Have you <a href="/account/password">forgot your password?</a>'));
                return;
            }

            //Everything is good, log the user in.
            session_start();
            //Login
            $_SESSION['Username'] = $e;
            $_SESSION['LoggedIn'] = 1;
        }
    }

    /* PASSWORD RESET */
    public function Password()
    {

    }
    public function Password_POST()
    {
        $e = $_POST['email'];

        //MODEL VALIDATION
        if(!isset($e) || $e == '')
        {
            $this->addModelError('email', new ModelError('Email address is required.'));
            return;
        }

        //Check if email and postcode match
        $sql = "SELECT COUNT(email) AS theCount FROM users WHERE email=:e";
        if($stmt = $this->database->prepare($sql)) {
            $stmt->bindParam(':e', $e, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch();

            $stmt->closeCursor();

            //Check if email exists
            if ($row['theCount'] < 1) {
                $this->addModelError('error', new ModelError('There\'s a problem finding your account'));
                return;
            }
        }

        $ver = '';

        //Get verification code
        $sql = "SELECT verification_code FROM users WHERE email=:e";
        if($stmt = $this->database->prepare($sql)) {
            $stmt->bindParam(':e', $e, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch();
            $ver = $row['verification_code'];
            $stmt->closeCursor();

        }

        //Update verified to unverified
        $sql = "UPDATE users SET is_pending_password_reset=1 WHERE email=:e";
        if($stmt = $this->database->prepare($sql)) {
            $stmt->bindParam(':e', $e, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
        }

        //Send password reset email
        $this->sendPasswordResetEmail($e, $ver);
    }

    /* RESET PASSWORD */
    public function ResetPassword($v, $e)
    {
        $sql = "SELECT *
          FROM users
          WHERE verification_code=:verification_code
          AND SHA1(email)=:email
          AND is_pending_password_reset=1";

        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':verification_code', $v, PDO::PARAM_STR);
            $stmt->bindParam(':email', $e, PDO::PARAM_STR);

            $stmt->execute();
            $row = $stmt->fetch();

            if(isset($row['email']))
            {
                $this->view->id = $row['id'];
                $this->view->email = $row['email'];
            }
        }
    }
    public function ResetPassword_POST()
    {
        $id = $_POST['id'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        //MODEL VALIDATION
        if(!isset($password) || $password == '')
        {
            $this->addModelError('password', new ModelError('Password is required.'));
            return;
        }

        if(!isset($confirm_password) || $confirm_password == '')
        {
            $this->addModelError('confirm_password', new ModelError('Please confirm your password.'));
            return;
        }

        if($password != $confirm_password)
        {
            $this->addModelError('confirm_password', new ModelError('Password do not match.'));
            return;
        }

        //Update records
        $sql = "UPDATE users
                SET password=SHA1(:p), is_pending_password_reset=0
                WHERE id=:id AND email=:e
                LIMIT 1";

        if($stmt = $this->database->prepare($sql)) {
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->bindParam(':e', $email, PDO::PARAM_STR);
            $stmt->bindParam(':p', $password, PDO::PARAM_STR);

            $stmt->execute();
            $stmt->closeCursor();
        }
    }

    //EMAIL SEND METHODS
    private function sendVerificationEmail($e, $v)
    {
        $to = $e;
        $e = sha1($e);
        $d = $this->config['domain'];
        $app_name = $this->config['app_name'];
        $email_support = $this->config['email_support'];

        $subject = "[$app_name] Please Verify Your Account";
        $body =
            <<<EMAIL
            You have a new account at $app_name!

            To get started, please activate your account by completing your registration.
            Just follow the link below.

            You can choose a secure password when you complete your activation.

            Activate your account: http://$d/account/verify/$v/$e

            If you have any questions, please contact $email_support.

            --
            Thanks!

            The Team
            www.$d
EMAIL;

        $email = new Email($this->config);
        return $email->SendEmail($to, $subject, $body);
    }
    private function sendPasswordResetEmail($e, $v)
    {
        $to = $e;
        $e = sha1($e);
        $d = $this->config['domain'];
        $app_name = $this->config['app_name'];
        $email_support = $this->config['email_support'];

        $subject = "[$app_name] Password Reset Request";
        $body =
            <<<EMAIL
            Your have requested a change of password, try to keep this one in a safe place!
            To reset your password follow the link below. You can choose a new secure password.

            Reset your password: http://$d/account/resetpassword/$v/$e

            If you have any questions or did not make this request, please contact $email_support.

            --
            Thanks!

            The Team
            www.$d
EMAIL;

        $email = new Email($this->config);
        return $email->SendEmail($to, $subject, $body);
    }

}