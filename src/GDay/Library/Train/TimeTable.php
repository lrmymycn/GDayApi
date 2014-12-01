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
    private $weekend;

    function __construct(){
        $this->trainService = new \GDay\Service\TrainService();
        $this->weekend = $this->isWeekend(date('Y-m-d'));
    }

    public function getNextTrain(){
        $suburbId = 1; //TODO

        $timeTable = $this->trainService->getNextTrainBySuburbId($suburbId, \GDay\Infrastructure\Enum\TrainDirection::FromCity, $this->weekend);

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

    private function isWeekend($date) {
        $weekDay = date('w', strtotime($date));
        return ($weekDay == 0 || $weekDay == 6);
    }

    private function getRealTimeData($suburbId, $direction) {
        try{
            $trainCode = $this->trainService->getTrainCodeBySuburbId($suburbId);

            if(!$trainCode){
                return null;
            }

            $directionCode = $direction == \GDay\Infrastructure\Enum\TrainDirection::ToCity ? "u" : "d";
            $uri = "";
            foreach($trainCode as $code) {
                $uri = $uri."CR_{$code}_{$directionCode},";
            }


            $uri = substr($uri, 0, -1);

            $url = "http://realtime.grofsoft.com/tripview/realtime?routes={$uri}&type=dv";

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
            $trainTime = $this->trainService->getTrainTimeByStartTimeAndSuburbIdAndDirection($delay['start_time'], $suburbId, $direction,$this->weekend);
            $arriveTime = date('H:i:s', strtotime($trainTime['planned_arrive_time']) + $delay['delay']*60);
            $this->trainService->updateArriveTime($trainTime,$arriveTime,$delay['delay']);
        }
    }

}
