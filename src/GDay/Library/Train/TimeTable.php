<?php
/**
 * Created by PhpStorm.
 * User: Huisan
 * Date: 26/11/14
 * Time: 12:01 AM
 */

namespace GDay\Library\Train;


class TimeTable {
    private $trainService;

    function __construct(){
        $this->trainService = new \GDay\Service\TrainService();
    }

    public function getNextTrain(){
        $suburbId = 1; //TODO

        $timeTable = $this->trainService->getNextTrainBySuburbId($suburbId, \GDay\Infrastructure\Enum\TrainDirection::FromCity);

        return $timeTable;
    }


    public function updateTimeTable(){
        $suburbId = 1; //TODO get form url

        $data = $this->getRealTimeData($suburbId, \GDay\Infrastructure\Enum\TrainDirection::FromCity);

        if($data != null && isset($data['delays'])){
            $delays = $this->parseData($data['delays']);

            $this->updateArriveTime($delays, $suburbId, \GDay\Infrastructure\Enum\TrainDirection::FromCity);
        }
    }

    private function getRealTimeData($suburbId, $direction) {
        try{
            $trainCode = $this->trainService->getTrainCodeBySuburbId($suburbId);

            if(!$trainCode){
                return null;
            }

            $directionCode = $direction == \GDay\Infrastructure\Enum\TrainDirection::ToCity ? "u" : "d";

            $url = "http://realtime.grofsoft.com/tripview/realtime?routes=CR_{$trainCode}_{$directionCode}&type=dv";

            //Pretend  to be a TripView ios app
            $options  = array('http' => array('user_agent' => 'TripViewLite/223 CFNetwork/548.1.4 Darwin/11.0.0'));
            $context  = stream_context_create($options);
            $response = file_get_contents($url, false, $context);

            return json_decode($response, true);
        }
        catch(\Exception $e){
            //TODO log error
            return null;
        }
    }

    private function parseData($delays){
        $tripDelays = array();
        $now = strtotime(date("G:i"));

        foreach ($delays as $route) {
            $tripDelay = array();
            $tripDelay['start_time'] = $route['start'];

            if (isset($route['offsets'])) {
                $offsets = explode(",", $route['offsets']);
                if (count($offsets) > 2) {
                    for ($i = count($offsets) - 2; $i >= 0; $i = $i - 2) {
                        $offset = strtotime($offsets[$i]);

                        if (($now - $offset) >= 0) {
                            $tripDelay['delay'] = $offsets[$i + 1];
                            break;
                        }
                    }
                } else {
                    $tripDelay['delay'] = $offsets[1];
                }
            } else {
                $tripDelay['delay'] = 0;
            }

            $tripDelays[] = $tripDelay;
        }
        return $tripDelays;
    }

    private function updateArriveTime($delays,$suburbId, $direction){
        foreach($delays as $delay) {
            $this->trainService->updateRealTimeTable($delay['start_time'], $suburbId, $direction, $delay['delay']);
        }
    }

}