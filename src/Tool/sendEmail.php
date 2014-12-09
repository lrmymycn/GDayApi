<?php
define( 'TOOL_PATH', dirname(__FILE__) . '/' );
require_once (TOOL_PATH . '../../bootstrap.php');

use \GDay\Infrastructure\Helper\EmailHelper;

if(count($argv) != 4){
    return;
}

$to = $argv[1];
$subject = $argv[2];
$body = $argv[3];

$result = EmailHelper::send($to, $subject, $body);