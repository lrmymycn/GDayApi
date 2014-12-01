<?php
//C:\wamp\bin\php\php5.4.12\php.exe -f C:/Projects/_sam/Gday/Api/src/Tool/train.php

define( 'TOOL_PATH', dirname(__FILE__) . '/' );
require_once (TOOL_PATH . '../../bootstrap.php');

$timeTable = new \GDay\Library\Train\TimeTable();
$timeTable->updateTimeTable();