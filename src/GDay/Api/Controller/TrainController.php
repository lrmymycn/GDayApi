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
        $timeTable = $this->timeTable->getNextTrain();

        $response = array(
            'arriveTime' => $timeTable['arrive_time'],
            'delay' => $timeTable['delay']
        );

        return $this->json($response);
    }
} 