<?php
/**
 * Created by PhpStorm.
 * User: Huisan
 * Date: 26/11/14
 * Time: 12:01 AM
 */

namespace GDay\Library\Train;


class TimeTable {


    private $TrainService;

    function __construct(){
        $this->trainService = new \GDay\Service\TrainService();
    }

    public function generateTimeTable(){

    }

    public function test(){
        // $toCityurl = self::getRealTimeDataUrl(1,1);
        // $toCityArray = self::getRealTimeData($toCityurl);
        // $result = self::updateArriveTime($toCityArray);
        //echo $result;
        $fromCityurl = self::getRealTimeDataUrl(1,0);
        $fromCityArray = self::getRealTimeData($fromCityurl);
        $result = self::updateArriveTime($fromCityArray, 0);

    }

    private function getRealTimeDataUrl($suburbID, $direction) {
        $trainCode = $this->trainService->getTrainCodeBySuburbId($suburbID);
        if($direction) {
            $directionCode = "u";
        } else {
            $directionCode = "d";
        }
        $url = "http://realtime.grofsoft.com/tripview/realtime?routes=CR_{$trainCode}_{$directionCode}&type=dv";
        return $url;
    }

    private function getRealTimeData($url){
        $result = file_get_contents($url);
        $json = json_decode($result, true);
        $arrayRoute = array();
        $now = strtotime(date("G:i"));
        $count = 0;
        foreach ($json['delays'] as $route) {
            $arrayRoute[$count] = array();
            $arrayRoute[$count]['start_time'] = $route['start'];
            if ($route['offsets']) {
                $delays = explode(",", $route['offsets']);
                if (count($delays) > 2) {
                    for ($i = count($delays) - 2; $i >= 0; $i = $i - 2) {
                        $delay = strtotime($delays[$i]);
                        if (($now - $delay) >= 0) {
                            $arrayRoute[$count]['delay'] = $delays[$i + 1];
                            break;
                        }
                    }
                } else {
                    $arrayRoute[$count]['delay'] = $delays[1];
                }
            } else {
                $arrayRoute[$count]['delay'] = 0;
            }
            $count++;
        }
        return $arrayRoute;
    }

    private function updateArriveTime($timeList, $direction){
        foreach($timeList as $time) {
            $plannedTime = $this->trainService->getPlannedTimeByStartTimeAndSuburbIdAndDirection($time['start_time'], 1, $direction);
            $arriveTime = date('H:i:s', strtotime($plannedTime) + $time['delay']*60);
            $this->trainService->updateArriveTimeBySuburbIdAndDirection($time['start_time'], $arriveTime, 1, $direction);
        }
    }

} 