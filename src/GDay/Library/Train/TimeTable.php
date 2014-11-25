<?php
/**
 * Created by PhpStorm.
 * User: Huisan
 * Date: 26/11/14
 * Time: 12:01 AM
 */

namespace GDay\Library\Train;


class TimeTable {

    public function generateTimeTable(){
        $t1 = self::readTimeTable('t1.html');

        //TODO parse html dom

        echo $t1;
    }

    private function  readTimeTable($fileName){
        $table = file_get_contents(TIME_TABLE_FOLDER . $fileName);

        return $table;
    }
} 