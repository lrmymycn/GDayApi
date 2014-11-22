<?php
require '../bootstrap.php';

// init app
$app = New \SlimController\Slim(array(
    'controller.class_prefix'    => '\\GDay\\Controller',
    'controller.class_suffix'   => 'Controller',
    'controller.method_suffix'   => 'Action',
));

$app->add(new \Slim\Middleware\ContentTypes());

$app->addRoutes(array(
    '/user'            => 'User:index'
));

$errorHandler = new \GDay\Infrastructure\Handler\ErrorHandler($app);
$errorHandler->register();

$app->run();