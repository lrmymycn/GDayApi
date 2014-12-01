<?php
/**
 * Created by PhpStorm.
 * User: Huisan
 * Date: 2/12/14
 * Time: 12:53 AM
 */

namespace GDay\Infrastructure\Utility;


class DateUtility {

    public static function isWeekend($date) {
        $weekDay = date('w', strtotime($date));
        return ($weekDay == 0 || $weekDay == 6);
    }
} 