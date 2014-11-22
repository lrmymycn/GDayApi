<?php
namespace GDay\Manager;


class UserManager {

    private $userService;

    function __construct(){
        $this->userService = new \GDay\Service\UserService();
    }

    public function authorize($loginModel){
        $user =  $this->userService->getUserByFacebookId($loginModel['facebookId']);

        echo $user;
    }
} 