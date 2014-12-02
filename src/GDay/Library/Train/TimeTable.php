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

    public function getNextTrain($trainId, $suburbId, $direction){
        $train = $this->trainService->getTrainCodeById($trainId);
        if($train == null){
            throw new \Exception('Train not found', 10001);
        }

        $isWeekend = \GDay\Infrastructure\Utility\DateUtility::isWeekend(date('Y-m-d'));
        $timeTable = $this->trainService->getNextTrainBySuburbId($suburbId, $direction, $isWeekend);

        $response = array(
            'arriveTime' => $timeTable['arrive_time'],
            'delay' => $timeTable['delay'],
            'destination' => $direction == \GDay\Infrastructure\Enum\TrainDirection::ToCity ? $train['destination_u'] : $train['destination_d']
        );

        return $response;
    }

    public function updateTimeTable(){
        $suburbId = 1; //TODO get form url

        $data = $this->getRealTimeData($suburbId);

        if($data != null && isset($data['delays'])){

            $delays = $this->parseData($data['delays']);

            $this->updateArriveTime($delays, $suburbId);

        }
    }

    private function getRealTimeData($suburbId) {
        try{
            $trainCode = $this->trainService->getTrainCodeBySuburbId($suburbId);

            if(!$trainCode){
                return null;
            }

            $uri = "";
            foreach($trainCode as $code) {
                $uri = $uri."CR_{$code}_d,CR_{$code}_u,";
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
            $tripDelay['direction']  = substr($route['route'], -1) == "u" ? 1 : 0;
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

    private function updateArriveTime($delays,$suburbId){
        $isWeekend = \GDay\Infrastructure\Utility\DateUtility::isWeekend(date('Y-m-d'));
        foreach($delays as $delay) {

            $trainTime = $this->trainService->getTrainTimeByStartTimeAndSuburbIdAndDirection($delay['start_time'], $suburbId, $delay['direction'], $isWeekend);

            $arriveTime = date('H:i:s', strtotime($trainTime['planned_arrive_time']) + $delay['delay']*60);

            $this->trainService->updateArriveTime($trainTime,$arriveTime,$delay['delay']);

        }
    }

}
