<?php
/**
 * Created by PhpStorm.
 * User: Huisan
 * Date: 23/11/14
 * Time: 9:52 PM
 */

namespace GDay\Service;


class ShopService extends BaseService{

    function __construct(){
        parent::__construct();
    }

    function getShopsBySuburbIdAndServiceId($suburbId, $serviceId){
        $sql = 'SELECT s.id, s.name
                FROM shop s
                LEFT JOIN service_shop ss ON s.id = ss.shop_id
                WHERE s.suburb_id = :suburbId AND ss.service_id = :serviceId';

        $query = $this->pdo->prepare($sql);
        $query->bindParam(':suburbId', $suburbId);
        $query->bindParam(':serviceId', $serviceId);

        if($data = $query->execute()){
            return $query->fetchAll(\PDO::FETCH_ASSOC);
        }else{
            return null;
        }
    }
} 