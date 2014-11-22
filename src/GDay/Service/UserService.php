<?php
/**
 * Created by PhpStorm.
 * User: Huisan
 * Date: 20/11/14
 * Time: 11:46 PM
 */

namespace GDay\Service;


class UserService extends BaseService{

    function __construct(){
        parent::__construct();
    }

    function getUserByFacebookId($facebookId){
        return "user";
    }
} 