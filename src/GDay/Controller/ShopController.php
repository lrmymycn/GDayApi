<?php
/**
 * Created by PhpStorm.
 * User: Huisan
 * Date: 23/11/14
 * Time: 10:00 PM
 */

namespace GDay\Controller;


class ShopController extends BaseController {

    private  $shopManager;

    function __construct(){
        parent::__construct();

        $this->shopManager = new \GDay\Manager\ShopManager();
    }

    public function indexAction(){
        $suburbId = intval($this->app->request->get('suburbId'));
        $serviceId = intval($this->app->request->get('serviceId'));

        $response = $this->shopManager->getShopsBySuburbIdAndServiceId($suburbId, $serviceId);

        return $this->json($response);
    }
} 