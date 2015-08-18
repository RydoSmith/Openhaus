<?php

class HTMLHelper
{
    public function __construct()
    {

    }

    public function DisplayErrorFor($m, $field)
    {
        if(isset($m) && isset($m->modelErrors[$field]))
        {
            echo '<p class="red-text" style="margin: 5px 0;">'.$m->modelErrors[$field]->message.'</p>';
        }
    }

    public function DisplayValueFor($m, $field)
    {
        if(isset($m) && isset($m->$field) && $m->$field != null)
        {
            echo 'value="'.$m->$field.'"';
        }
    }

    public function GetAssociativeArrayByIndex($array, $index)
    {
        if(isset($array))
        {
            $keys = array_keys($array);
            if(isset($array[$keys[$index]]) && isset($array[$keys[$index]]->wizardPage))
            {
                echo $array[$keys[$index]]->wizardPage;
            }
        }
    }

    public static function IsLoggedIn()
    {
        if($_SESSION['LoggedIn'] == 1 && isset($_SESSION['Username']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }


}