<?php
/**
 * Created by PhpStorm.
 * User: Huisan
 * Date: 21/11/14
 * Time: 12:07 AM
 */

namespace GDay\Infrastructure\Handler;


class ErrorHandler {
    private $app;

    public function __construct(\Slim\Slim &$app){
        $this->app = $app;
    }

    public function register(){
        $app = $this->app;

        // set debug mode as false, otherwise Slim will handle exceptions with default error handler
        $app->config('debug', false);

        $app->error(function (\Exception $e) use ($app) {
            error_log('ERROR Code: ' . $e->getCode());
            error_log('ERROR Message: '.  $e->getMessage());
            error_log('ERROR Trace: ' . $e->getTraceAsString());
            echo \GDay\Infrastructure\Helper\ResponseHelper::json($app, '', 200, $e->getCode(), $e->getMessage(), $e->getTraceAsString());
        });
    }
} 