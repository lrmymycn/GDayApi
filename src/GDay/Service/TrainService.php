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

    function createTrip($trip){
        return $this->db->train_trip()->insert($trip);
    }

    function createTimeTable($timetable){
        return $this->db->train_timetable()->insert($timetable);
    }

    function getTripByStartTime($stationId, $departTime){
        $trip = $this->db->train_trip()->where(array("train_station_id" => $stationId, "depart_time" => $departTime, "is_deleted" => 0));

        if ($data = $trip->fetch()) {
            return $data;
        }else{
            return null;
        }
    }
} 