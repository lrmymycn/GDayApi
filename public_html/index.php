<?php
require '../bootstrap.php';

// init app
$app = New \SlimController\Slim(array(
    'controller.class_prefix'    => '\\GDay\\Api\\Controller',
    'controller.class_suffix'   => 'Controller',
    'controller.method_suffix'   => 'Action',
));

$app->add(new \Slim\Middleware\ContentTypes());

$app->addRoutes(array(
    '/user'            => 'User:index',
    '/service'        => 'Service:index',
    '/shop'           => 'Shop:index'
));

$errorHandler = new \GDay\Api\Infrastructure\Handler\ErrorHandler($app);
$errorHandler->register();

$trainTime = new \GDay\Library\Train\TimeTable;
$trainTime->test();
//$trainTime->getRealTimeData("http://realtime.grofsoft.com/tripview/realtime?routes=CR_nta_d&type=dv");

$app->run();
