<?php
/**
 * Created by PhpStorm.
 * User: Huisan
 * Date: 9/12/14
 * Time: 11:01 PM
 */

namespace GDay\Infrastructure\Helper;

use \Aws\Ses\SesClient;

class EmailHelper {

    static public function sendAsyncEmail($to, $subject, $body){
        if(OS == 'WIN'){
            $WshShell = new \COM("WScript.Shell");
            $oExec = $WshShell->Run(EMAIL_COMMAND . " $to \"$subject\" \"$body\"", 0, false);
        }else{
            exec(EMAIL_COMMAND . " $to \"$subject\" \"$body\" > /dev/null 2>&1 &");
        }
    }

    static public  function send($to,$subject, $body){
        // Instantiate the S3 client with your AWS credentials
        $sesClient = SesClient::factory(array(
            'key'    => AWS_ACCESS_KEY_ID,
            'secret' => AWS_SECRET_KEY,
            'region'  => AWS_SES_REGION
        ));

        $result = $sesClient->sendEmail(array(
            'Source' => AWS_SES_FROM,
            'Destination' => array(
                'ToAddresses' => array($to)
            ),
            'Message' => array(
                'Subject' => array(
                    'Data' => $subject
                ),
                'Body' => array(
                    'Html' => array(
                        'Data' => $body
                    ),
                )
            )
        ));

        if(isset($result['MessageId'])){
            return true;
        }else{
            return false;
        }
    }
} 