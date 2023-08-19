<?php

namespace App\Helpers;

class DatetimeHelper
{

    /**
     * @return string
     */
    public static function getDatetime(): string
    {
        return date('Y-m-d H:i:s');
    }

}
