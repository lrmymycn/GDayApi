<?php
/**
 * Created by PhpStorm.
 * User: Huisan
 * Date: 9/12/14
 * Time: 11:01 PM
 */

namespace GDay\Api\Controller;


class FeedbackController extends BaseController{

    function __construct(){
        parent::__construct();
    }

    public function indexAction(){
        if($this->app->request->isPost()){
            $this->getRequestBody();
            $this->validate(array('message'));

            $body = 'Message: ' . $this->requestBody['message'] . '<br/>';
            $body .= 'Email: ' . $this->requestBody['email'];

            \GDay\Infrastructure\Helper\EmailHelper::sendAsyncEmail(ADMIN_EMAIL,EMAIL_FEEDBACK_SUBJECT, $body);

            return $this->success();
        }
    }
} 