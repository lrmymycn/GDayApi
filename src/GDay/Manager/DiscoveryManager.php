<?php
/**
 * Created by PhpStorm.
 * User: Huisan
 * Date: 23/11/14
 * Time: 9:27 PM
 */

namespace GDay\Manager;


class DiscoveryManager {

    private $discoveryService;

    function __construct(){
        $this->discoveryService = new \GDay\Service\DiscoveryService();
    }

    function getDiscoveriesBySuburbId($suburbId){
        $discoveries = $this->discoveryService->getDiscoveriesBySuburbId($suburbId);

        $discoveryList = array();
        foreach($discoveries as $discovery){
            $discoveryItem = array(
                'id' => $discovery['id'],
                'name' => $discovery['name']
            );

            $discoveryList[] = $discoveryItem;
        }

        return $discoveryList;
    }
} 