<?php
/**
 * Created by PhpStorm.
 * User: Huisan
 * Date: 6/12/14
 * Time: 2:50 PM
 */

namespace GDay\Api\Controller;


class HomeController extends BaseController{

    private $timeTable;

    function __construct(){
        parent::__construct();

        $this->timeTable = new \GDay\Library\Train\TimeTable;
    }

    function indexAction(){
        $direction =  \GDay\Infrastructure\Enum\TrainDirection::FromCity;
        $toCity = $this->app->request->get('toCity');
        if($toCity == 1){
            $direction = \GDay\Infrastructure\Enum\TrainDirection::ToCity;
        }
        $suburbId = 1; //TODO

        $nextTrain = $this->timeTable->getNextTrain($suburbId, $direction);

        $response = array(
            'nextTrain' => $nextTrain
        );
        return $this->json($response);
    }
} 