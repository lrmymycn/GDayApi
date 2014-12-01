<?php
/**
 * Created by PhpStorm.
 * User: Huisan
 * Date: 2/12/14
 * Time: 12:14 AM
 */

namespace GDay\Api\Controller;


class TrainController extends BaseController{

    private $timeTable;

    function __construct(){
        parent::__construct();

        $this->timeTable = new \GDay\Library\Train\TimeTable;
    }

    function nextTrainAction(){
        $direction =  \GDay\Infrastructure\Enum\TrainDirection::FromCity;
        $toCity = $this->app->request->get('toCity');
        if($toCity == 1){
            $direction = \GDay\Infrastructure\Enum\TrainDirection::ToCity;
        }
        $suburbId = 1; //TODO

        $timeTable = $this->timeTable->getNextTrain($suburbId, $direction);

        $response = array(
            'arriveTime' => $timeTable['arrive_time'],
            'delay' => $timeTable['delay']
        );

        return $this->json($response);
    }
} 