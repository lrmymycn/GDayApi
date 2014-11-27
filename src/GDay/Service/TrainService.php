<?php
/**
 * Created by PhpStorm.
 * User: Huisan
 * Date: 25/11/14
 * Time: 11:48 PM
 */

namespace GDay\Service;


class TrainService extends BaseService{

    function __construct(){
        parent::__construct();
    }

    function createStation($station){
        return $this->db->train_station()->insert($station);
    }

    function getNextTrainBySuburbId($suburbId){
        
    }

    function getTrainCodeBySuburbId($suburbId){
        $row = $this->db->train_code()->where(array("suburb_id" => $suburbId, "is_deleted" => 0));
        if ($data = $row->fetch()) {
            return $data["code"];
        }else{
            return null;
        }
    }

    function updateRealTimeTable($startTime,$suburbId, $direction, $minutes){
        $sql = 'UPDATE train_time
               SET arrive_time = DATE_ADD(planned_arrive_time, INTERVAL %s MINUTE), date_updated = NOW()
               WHERE start_time = :startTime AND suburb_id = :suburbId AND direction = :direction AND is_deleted = 0';

        $sql = sprintf($sql, $minutes);

        $query = $this->pdo->prepare($sql);
        $query->bindParam(':startTime', $startTime);
        $query->bindParam(':suburbId', $suburbId);
        $query->bindParam(':direction', $direction);

        $query->execute();
    }
} 