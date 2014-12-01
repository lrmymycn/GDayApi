<?php
/**
 * Created by PhpStorm.
 * User: Huisan
 * Date: 23/11/14
 * Time: 9:27 PM
 */

namespace GDay\Api\Controller;


class DiscoveryController extends BaseController{

    private  $discoveryManager;

    function __construct(){
        parent::__construct();

        $this->discoveryManager = new \GDay\Manager\DiscoveryManager();
    }

    public function indexAction()
    {
        $response = $this->discoveryManager->getDiscoveriesBySuburbId(1);

        return $this->json($response);
    }
} 