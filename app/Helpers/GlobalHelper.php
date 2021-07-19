<?php

namespace App\Helpers;

use App\Constants\GlobalConstant;

class GlobalHelper
{
    /**
     * @return false|string
     */
    public static function nowDate()
    {
        return date('Y-m-d H:i:s');
    }

    /**
     * @param null $date
     * @param null $day
     * @param string $format
     * @return false|string
     */
    public static function dateDayAfter($date = null, $day = null, $format = GlobalConstant::DATE_TIME_FORMAT)
    {
        $date = is_null($date) ? self::nowDate() : $date;
        $day = is_null($day) ? GlobalConstant::DAY_ZERO : $day;

        $dayAfter = strtotime('+' . $day . ' day', strtotime($date));

        return date($format, $dayAfter);
    }

    /**
     * @param null $day
     * @param null $date
     * @param string $format
     * @return false|string
     */
    public static function dateDayBefore($day = null, $date = null, $format = GlobalConstant::DATE_TIME_FORMAT)
    {
        $date = is_null($date) ? self::nowDate() : $date;
        $day = is_null($day) ? GlobalConstant::DAY_ZERO : $day;

        $dayAfter = strtotime('-' . $day . ' day', strtotime($date));

        return date($format, $dayAfter);
    }
}
