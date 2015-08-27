<?php

return array
(
    //App Config
    'app_name'      => 'Openhaus',
    'environment'   => 'test',          //Change to production on deploy
    'domain'        => 'openhaus.krftwrk.ca',

    //Database
    'db_location'   => 'localhost',
    'db_name'       => 'openhaus',
    'db_user'   => 'root',
    'db_pass'   => 'r160689s',

    //Email Settings
    'email_system'  => 'ryan@krftwrk.ca',
    'email_support'  => 'support@openhaus.it',

    //Testing locally
    'smtp_host'  => 'smtp.gmail.com',
    'smtp_user'  => 'rydosmith2@gmail.com',
    'smtp_password'  => 'R160689s',
    'smtp_port'  => '465',
    'smtp_secure' => 'ssl' // secure transfer enabled REQUIRED for GMail



    //Test server
//    'smtp_host'  => 'smtp.postmarkapp.com',
//    'smtp_user'  => 'bfd19866-de79-4fce-a569-1b828feff203',
//    'smtp_password'  => 'bfd19866-de79-4fce-a569-1b828feff203',
//    'smtp_port' => '587'

);