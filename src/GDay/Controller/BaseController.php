<?php
namespace GDay\Controller;


class BaseController extends \SlimController\SlimController{

    protected $app;
    protected $requestBody;

    function __construct(){
        $this->app =  $app = \Slim\Slim::getInstance();

        parent::__construct($app);
    }

    protected function json($result) {
        echo \GDay\Infrastructure\Helper\ResponseHelper::json($this->app, $result);
    }

    protected function success(){
        echo \GDay\Infrastructure\Helper\ResponseHelper::json($this->app,'',200,0, 'success');
    }
} 