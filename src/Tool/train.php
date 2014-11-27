<?php
define( 'TOOL_PATH', dirname(__FILE__) . '/' );
require_once (TOOL_PATH . '../../bootstrap.php');

$timeTable = new \GDay\Library\Train\TimeTable();
$timeTable->updateTimeTable();