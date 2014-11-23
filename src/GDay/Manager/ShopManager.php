<?php
/**
 * Created by PhpStorm.
 * User: Huisan
 * Date: 23/11/14
 * Time: 9:56 PM
 */

namespace GDay\Manager;


class ShopManager {

    private $shopService;

    function __construct(){
        $this->shopService = new \GDay\Service\ShopService();
    }

    function getShopsBySuburbIdAndServiceId($suburbId, $serviceId){
        $shops = $this->shopService->getShopsBySuburbIdAndServiceId($suburbId, $serviceId);

        $shopList = array();
        foreach($shops as $shop){
            $shopItem = array(
                'id' => $shop['id'],
                'name' => $shop['name']
            );

            $shopList[] = $shopItem;
        }

        return $shopList;
    }
} 