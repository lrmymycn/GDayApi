<?php
/**
 * Created by PhpStorm.
 * User: Huisan
 * Date: 23/11/14
 * Time: 9:07 PM
 */

namespace GDay\Service;


class ServiceService extends BaseService{

    function __construct(){
        parent::__construct();
    }

    function getServicesBySuburbId($suburbId){
        $sql = 'SELECT s.id, s.name
                FROM suburb_service ss
                LEFT JOIN service s ON ss.service_id = s.id AND s.is_deleted = 0
                WHERE ss.is_deleted = 0 AND ss.suburb_id = :suburbId
                ORDER BY ss.sort';

        $query = $this->pdo->prepare($sql);
        $query->bindParam(':suburbId', $suburbId);

        if($data = $query->execute()){
            return $query->fetchAll(\PDO::FETCH_ASSOC);
        }else{
            return null;
        }
    }
} 