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
        $email = trim($_POST['email']);
        $verification_code = sha1(time());

        $sql = "SELECT COUNT(email) AS theCount FROM users WHERE email=:email";
        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch();

            //Check if email exists
            if($row['theCount'] != 0)
            {
                $this->addModelError('email', new ModelError('This email address already exists.'));
                return;
            }

            //Send verification email
            if(!$this->sendVerificationEmail($email, $verification_code))
            {
                $this->addModelError('error', new ModelError('There was a problem sending the email.'));
                return;
            }

            $stmt->closeCursor();
        }

        //Create and insert user
        $sql = "INSERT INTO users(email, verification_code) VALUES (:email, :verification_code)";

        if($stmt = $this->database->prepare($sql))
        {
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':verification_code', $verification_code, PDO::PARAM_STR);

            $stmt->execute();
            $stmt->closeCursor();
        }
    }

    public function Login()
    {

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