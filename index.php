<?php

    ini_set('display_startup_errors',1);
    ini_set('display_errors',1);
    error_reporting(-1);

    //Require base classes
    require_once 'common/loader.php';
    require_once 'common/basecontroller.php';
    require_once 'common/basemodel.php';
    require_once 'common/messagetype.php';
    require_once 'common/email.php';
    require_once 'common/modelerror.php';

    //Require helpers
    require_once 'helpers/htmlhelper.php';
    require_once 'helpers/chelper.php';

    //Require models
    require_once 'models/homemodel.php';
    require_once 'models/errormodel.php';
    require_once 'models/accountmodel.php';
    require_once 'models/eventmodel.php';

    //Remove from live
    require_once 'models/gmodel.php';

    //Require controllers
    require_once 'controllers/error.php';
    require_once 'controllers/home.php';
    require_once 'controllers/account.php';
    require_once 'controllers/event.php';

    //Remove from live
    require_once 'controllers/g.php';

    //create controllers and execute the action
    $loader = new Loader($_GET);

    $controller = $loader->CreateController();
    $controller->ExecuteAction();

