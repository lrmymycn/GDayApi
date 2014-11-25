<?php
namespace GDay\Api\Controller;


class UserController extends BaseController{

    private  $userManager;

    function __construct(){
        parent::__construct();

        $this->userManager = new \GDay\Manager\UserManager();
    }

    public function indexAction()
    {
        $loginModel = array(
            'facebookId' => '123'
        );
        $this->userManager->authorize($loginModel);
    }

} 