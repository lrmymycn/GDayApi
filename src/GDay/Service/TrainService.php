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

    function getTrainCodeBySuburbId($suburbId){
        $row = $this->db->train_code()->where(array("suburb_id" => $suburbId, "is_deleted" => 0));
        if ($data = $row->fetch()) {
            return $data["code"];
        }else{
            return null;
        }
    }

    function getPlannedTimeByStartTimeAndSuburbIdAndDirection($startTime, $suburbId, $direction){
        $row = $this->db->train_time()->where(array("suburb_id" => $suburbId, "start_time" => $startTime, "direction" => $direction, "is_deleted" => 0));
        if ($data = $row->fetch()) {
            return $data["planned_arrive_time"];
        }else{
            return null;
        }
    }

    function updateArriveTimeBySuburbIdAndDirection($startTime, $arriveTime, $suburbId, $direction){
        $row = $this->db->train_time()->where(array("start_time" => $startTime, "suburb_id" => $suburbId, "direction" => $direction, "is_deleted" => 0));

        if ($row) {
            $data = array(
                "arrive_time" => $arriveTime
            );
            return $row->update($data);
        }
    }
} 