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
        $trainId = 1;

        $response = $this->timeTable->getNextTrain($trainId, $suburbId, $direction);

        return $this->json($response);
    }
} 