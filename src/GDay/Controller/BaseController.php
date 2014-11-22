<?php
namespace GDay\Controller;


class BaseController extends \SlimController\SlimController{

    protected $app;
    protected $requestBody;

    function __construct(){
        $this->app =  $app = \Slim\Slim::getInstance();

        parent::__construct($app);
    }
} 