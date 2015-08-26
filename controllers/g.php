<?php

class G extends BaseController
{
    public function __construct($action, $urlParams)
    {
        parent::__construct($action, $urlParams);
    }

    //IMPORTANT - REMOVE WHEN LIVE
    //Sample
    //IMPORTANT - REMOVE WHEN LIVE
    public function Run()
    {
        $model = new GModel("Run", false);
        echo "Sample Data Generated";
        exit();
    }
}