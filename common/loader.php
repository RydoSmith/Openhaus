<?php

class Loader
{
    private $controller, $action, $urlValues, $urlParams;

    //store url values on object creation
    public function __construct($u)
    {
        if(isset($u['url']))
        {
            $this->urlValues = explode("/", $u['url']);
            $this->urlParams = array();

            //Controller logic from url
            if (isset($this->urlValues[0]) && $this->urlValues[0] != "")
            {
                if(!class_exists($this->urlValues[0]))
                {
                    //If the first 'url part' isn't a controller check and see if there's a method on the Home controller
                    //that matches the request
                    $tmp = new Home('Index', '');
                    if(method_exists($tmp, $this->urlValues[0]))
                    {
                        //If the method exits presume home controller and set action
                        $this->controller = 'Home';
                        $this->action = $this->urlValues[0];
                    }
                }
                else
                {
                    $this->controller = $this->urlValues[0];
                }
            }
            else
            {
                $this->controller = 'Home';
            }

            //Action logic from url
            if (isset($this->urlValues[1]) &&  $this->urlValues[1] != "")
            {
                $this->action = $this->urlValues[1];
            }
            else
            {
                //If the action isn't requested in the url and the action hasn't been set based on
                //the previous method checking if its a method on the home controller presume index
                if(!isset($this->action) || $this->action == "")
                {
                    $this->action = 'Index';
                }
            }

            for($i = 2; $i < count($this->urlValues); $i++)
            {
                if(isset($this->urlValues[$i]) && $this->urlValues[$i] != "")
                {
                    array_push($this->urlParams, $this->urlValues[$i]);
                }
            }
        }
        else
        {
            $this->controller = 'Home';
            $this->action = 'Index';
        }
    }

    //Establish the requested controller as an object
    public function CreateController()
    {
        if(class_exists($this->controller))
        {
            $parents = class_parents($this->controller);

            //does the class extend the controller class
            //if not error to bad url
            if(in_array('BaseController', $parents))
            {
                //does the class contain the requested method
                //if not error to bad url
                if(method_exists($this->controller, $this->action))
                {
                    return new $this->controller($this->action, $this->urlParams);
                }
                else
                {
                    return new Error('BadUrl', $this->urlValues);
                }
            }
            else
            {
                return new Error('BadUrl', $this->urlValues);
            }
        }
        else
        {
            return new Error('BadUrl', $this->urlValues);
        }
    }
}