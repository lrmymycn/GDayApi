<?php
/**
 * Created by PhpStorm.
 * User: Huisan
 * Date: 23/11/14
 * Time: 9:27 PM
 */

namespace GDay\Manager;


class ServiceManager {

    private $serviceService;

    function __construct(){
        $this->serviceService = new \GDay\Service\ServiceService();
    }

    function getServicesOfUser($user){
        $services = $this->serviceService->getServicesBySuburbId($user['suburb_id']);

        $serviceList = array();
        foreach($services as $service){
            $serviceItem = array(
                'id' => $service['id'],
                'name' => $service['name']
            );

            $serviceList[] = $serviceItem;
        }

        return $serviceList;
    }
} 