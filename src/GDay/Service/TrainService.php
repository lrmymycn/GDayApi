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

    function getNextTrainBySuburbId($suburbId, $direction, $isWeekend){
        $sql = 'SELECT * FROM gday.train_time
                WHERE arrive_time > CURTIME() AND direction = :direction AND suburb_id = :suburbId AND is_weekend = :isWeekend
                ORDER BY arrive_time
                LIMIT 1';

        $query = $this->pdo->prepare($sql);
        $query->bindParam(':suburbId', $suburbId);
        $query->bindParam(':direction', $direction);
        $query->bindParam(':isWeekend', $isWeekend);

        if($data = $query->execute()){
            return $query->fetch();
        }else{
            return null;
        }
    }

    function getTrainsBySuburbId($suburbId){

        $rows = $this->db->train_code()->where(array("suburb_id" => $suburbId, "is_deleted" => 0));

        if($rows){
            return $rows;
        } else {
            return null;
        }
    }

    function getTrainCodeBySuburbId($suburbId){
        $rows = $this->db->train_code()->where(array("suburb_id" => $suburbId, "is_deleted" => 0));
        if($rows){
            $codes = array();
            foreach ($rows as $row) {
                $codes[] = $row[code];
            }
            return $codes;
        } else {
            return null;
        }

    }

    function getTrainTimeByStartTimeAndSuburbIdAndDirection($startTime, $suburbId, $direction, $weekend){
        $row = $this->db->train_time()->where(array("suburb_id" => $suburbId, "start_time" => $startTime, "direction" => $direction, "is_deleted" => 0, "is_weekend" => $weekend));
        if ($data = $row->fetch()) {
            return $data;
        }else{
            return null;
        }
    }

    function updateArriveTime($trainTime, $arriveTime, $delayTime){
        $data = array(
            'date_updated' => date('Y-m-d H:i:s'),
            "arrive_time" => $arriveTime,
            "delay" => $delayTime
        );
        return $trainTime->update($data);
    }
} 