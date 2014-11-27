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

    function getNextTrainBySuburbId($suburbId, $direction){
        $sql = 'SELECT * FROM gday.train_time
                WHERE arrive_time > CURTIME() AND direction = :direction AND suburb_id = :suburbId
                ORDER BY arrive_time
                LIMIT 1';

        $query = $this->pdo->prepare($sql);
        $query->bindParam(':suburbId', $suburbId);
        $query->bindParam(':direction', $direction);

        if($data = $query->execute()){
            return $query->fetch();
        }else{
            return null;
        }
    }

    function getTrainCodeBySuburbId($suburbId){
        $rows = $this->db->train_code()->where(array("suburb_id" => $suburbId, "is_deleted" => 0));
        if($rows){
            $codes = array();
            $i = 0;
            foreach ($rows as $row) {
                $codes[$i] = $row[code];
                $i++;
            }
            return $codes;
        } else {
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