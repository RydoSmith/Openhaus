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
            echo '<p class="red-text" style="margin: 2px 0; text-align: right">'.$m->modelErrors[$field]->message.'</p>';
        }
    }

    public function FieldHasError($m, $field)
    {
        if(isset($m) && isset($m->modelErrors[$field]))
        {
            return 'has-error';
        }
    }

    public function IsSelected($field, $value)
    {
        if($field == $value)
        {
            echo "selected=\"selected\"";
        }
    }

    public function DisplayValueFor($m, $field)
    {
        if(isset($m) && isset($m->post) && isset($m->post[$field]) && $m->post[$field] != null)
        {
            echo 'value="'.$m->post[$field].'"';
        }
    }

    public function DisplayTextareaValueFor($m, $field)
    {
        if(isset($m) && isset($m->post) && isset($m->post[$field]) && $m->post[$field] != null)
        {
            echo $m->post[$field];
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
        if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] == 1 && isset($_SESSION['Username']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public static function TimeElapsedString($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }


}