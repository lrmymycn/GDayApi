<?php
namespace GDay\Api\Controller;


class BaseController extends \SlimController\SlimController{

    protected $app;
    protected $requestBody;

    function __construct(){
        $this->app =  $app = \Slim\Slim::getInstance();

        parent::__construct($app);
    }

    protected function getRequestBody(){
        if(!$this->requestBody){
            $this->requestBody = $this->app->request->getBody();

            if(!is_array($this->requestBody)){
                throw new \Exception('Not a valid JSON request. Please check your data.', 10005);
            }
        }
    }

    protected function validate($fields){
        foreach ($fields as $field) {
            //TODO double check empty logic
            if(!isset($this->requestBody[$field])){
                throw new \Exception( $field .' is required', 10006);
            }
        }
    }

    protected function json($result) {
        echo \GDay\Api\Infrastructure\Helper\ResponseHelper::json($this->app, $result);
    }

    protected function success(){
        echo \GDay\Api\Infrastructure\Helper\ResponseHelper::json($this->app,'',200,0, 'success');
    }
} 