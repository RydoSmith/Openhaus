<?php

abstract class BaseController
{
    protected $action, $urlValues, $urlParams;
    public $htmlHelper;

    public function __construct($action, $urlParams)
    {
        $this->action = $action;
        $this->urlParams = $urlParams;
        $this->htmlHelper = new HTMLHelper();

        if(!isset($_SESSION))
        {
            session_start();
        }

//        if (isset($_SESSION['Username']) && isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] == 1)
//        {
//            $this->Redirect('home');
//        }
    }

    public function ExecuteAction()
    {
        if(!isset($this->urlParams))
        {
            $this->urlParams = array();
        }

        return call_user_func_array(array($this, $this->action), $this->urlParams);
    }

    //Views and Redirects
    protected function ReturnView($model, $layoutname = "layout")
    {

        $location = 'views/'.strtolower(get_class($this)).'/'.strtolower($this->action).'.php';

        if($layoutname)
        {
            require('views/shared/layouts/'.$layoutname.'.php');
        }
        else
        {
            require($location);
        }
    }

    protected function ReturnViewByName($name, $model, $layoutname = "layout")
    {

        $location = 'views/'.strtolower(get_class($this)).'/'.$name.'.php';

        if($layoutname)
        {
            require('views/shared/layouts/'.$layoutname.'.php');
        }
        else
        {
            require($location);
        }
    }

    protected function RedirectToAction($name, $model)
    {
        $this->action = $name;
        $this->{$this->action}($model);
    }

    protected function Redirect($controller = '', $action = '', $param = null)
    {
        if($action == '')
        {
            header('Location: /'.$controller);
        }
        else if(isset($controller) && isset($action) && !isset($param))
        {
            header('Location: /'.$controller.'/'.$action);
        }
        else
        {
            header('Location: /'.$controller.'/'.$action.'/'.$param);
        }
    }
}

