<?php
ini_set('date.timezone','Australia/Sydney');

/** Define ABSPATH as this file's directory */
define( 'ABSPATH', dirname(__FILE__) . '/' );

require_once(ABSPATH . 'local.php');
require_once(ABSPATH . 'vendor/autoload.php');