<?php

namespace App\Helpers;


use Carbon\Carbon;

class DateFormatHelper
{
    /**
     * Convert a date string in the format 'd-m-Y' to 'D d/m/Y'.
     *
     * @param string $date
     * @return string
     */
    public static function formatDate($date)
    {
        // Parse the date string to a Carbon instance
        $dateInstance = Carbon::createFromFormat('Y-m-d', $date);
        // Format the date to the desired format
        return $dateInstance->format('D d/m/Y');
    }
}