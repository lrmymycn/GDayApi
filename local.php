<?php
/*
 * Manually update local configuration here.
 * Do not override staging or live settings.
 */

define('ENVIRONMENT', 'development');
define('OS', 'WIN');
define('APP_NAME', 'GDay');
define('ADMIN_EMAIL', 'huisan@outlook.com');

/**
 * MySQL Connection
 */
define('DB_NAME', 'gday');
define('DB_USER', 'gday');
define('DB_PASSWORD', 'gday');
define('DB_HOST', 'localhost');

/**
 * AWS
 */
define('EMAIL_COMMAND', 'C:/wamp/bin/php/php5.5.19/php.exe -f C:/Projects/_sam/Gday/Api/src/Tool/sendEmail.php');
define('AWS_SES_REGION', 'us-west-2');
define('AWS_ACCESS_KEY_ID', 'AKIAJ4EVJFAL6BV3U7GA');
define('AWS_SECRET_KEY', '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');
define('AWS_SES_FROM', 'noreply@ppost.com.au');
define('EMAIL_FEEDBACK_SUBJECT', 'A feedback from gday');