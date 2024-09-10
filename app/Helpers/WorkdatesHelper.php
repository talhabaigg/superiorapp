<?php

namespace App\Helpers;

use DateTime;
use DateTimeZone;

class WorkdatesHelper
{
    /**
     * Get the last n workdays.
     *
     * @param int $numDays The number of workdays to retrieve.
     * @param string $timezone The timezone to use, defaults to 'Australia/Sydney'.
     * @return array The list of workdays in 'Y-m-d' format.
     */
    public static function getLastWorkdays($numDays = 400, $timezone = 'Australia/Sydney')
    {
        $workdays = [];
        $timezone = new DateTimeZone($timezone);
        $currentDate = new DateTime('now', $timezone);

        // Include today's date first if it's a workday
        if ($currentDate->format('N') >= 1 && $currentDate->format('N') <= 5) {
            $workdays[] = $currentDate->format('Y-m-d');
        }

        // Continue fetching previous workdays
        while (count($workdays) < $numDays) {
            $currentDate->modify('-1 day');
            $currentDay = $currentDate->format('N'); // Get day of the week (1 = Monday, ..., 7 = Sunday)

            if ($currentDay >= 1 && $currentDay <= 5) { // Workday (Mon-Fri)
                $workdays[] = $currentDate->format('Y-m-d');
            }
        }

        return $workdays;
    }
}
