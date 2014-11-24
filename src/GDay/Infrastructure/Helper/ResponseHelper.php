<?php
/**
 * Created by PhpStorm.
 * User: Huisan
 * Date: 21/11/14
 * Time: 12:08 AM
 */

namespace GDay\Infrastructure\Helper;


class ResponseHelper {

    static function json($app, $result = '', $status_code = 200, $error_code = 0, $message = '', $debug = '') {
        // Http response code
        $app->status($status_code);

        // setting response content type to json
        $app->contentType('application/json');

        // allow cross domain
        $app->response->header('Access-Control-Allow-Origin', '*');

        $response = array();
        $response['errorCode'] = $error_code;
        $response['message'] = $message;

        // Remove debug message on live server
        if(ENVIRONMENT === 'live'){
            $debug = '';
        }

        $response['debug'] = $debug;
        $response['result'] = $result;

        return json_encode($response);
    }
} 