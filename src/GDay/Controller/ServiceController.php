<?php
/**
 * Created by PhpStorm.
 * User: Huisan
 * Date: 23/11/14
 * Time: 9:27 PM
 */

namespace GDay\Controller;


class ServiceController extends BaseController{

    private  $serviceManager;

    function __construct(){
        parent::__construct();

        $this->serviceManager = new \GDay\Manager\ServiceManager();
    }

    public function indexAction()
    {
        $response = $this->serviceManager->getServicesBySuburbId(1);

        return $this->json($response);
    }
} 