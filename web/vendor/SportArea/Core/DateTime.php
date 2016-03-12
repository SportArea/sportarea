<?php

namespace SportArea\Core;

class DateTime
{

    /**
     * Transform a human date to machine date
     * 	eg: 01.09.2013 => 2013-09-01
     *
     * @param type $date
     */
    public static function dateToMachine($date = null, $humanFormat)
    {

        if (preg_match('/\s+/', $date)) {
            list($date, $time) = explode(' ', $date);
        }

        switch ($humanFormat) {
            case 'Y-m-d':
                if (!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $date)) {
                    return $date;
                }
                list($year, $month, $day) = explode('-', $date);
                break;

            case 'Y.m.d':
                if (!preg_match('/^[0-9]{4}\.[0-9]{2}\.[0-9]{2}$/', $date)) {
                    return $date;
                }
                list($year, $month, $day) = explode('.', $date);
                break;

            case 'Y/m/d':
                if (!preg_match('/^[0-9]{4}\/[0-9]{2}\/[0-9]{2}$/', $date)) {
                    return $date;
                }
                list($year, $month, $day) = explode('/', $date);
                break;

            case 'd-m-Y':
                if (!preg_match('/^[0-9]{2}-[0-9]{2}-[0-9]{4}$/', $date)) {
                    return $date;
                }
                list($day, $month, $year) = explode('-', $date);
                break;

            case 'd.m.Y':
                if (!preg_match('/^[0-9]{2}\.[0-9]{2}\.[0-9]{4}$/', $date)) {
                    return $date;
                }
                list($day, $month, $year) = explode('.', $date);
                break;

            case 'd/m/Y':
                if (!preg_match('/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/', $date)) {
                    return $date;
                }
                list($day, $month, $year) = explode('/', $date);
                break;

            default:
                break;
        }

        return "{$year}-{$month}-{$day}";
    }

    /**
     * Transform a machine date to human date
     * 	eg: 01.09.2013 => 2013-09-01
     *
     * @param type $date
     */
    public static function dateToHuman($date = null, $type = 'date|datetime|datetime-s|time|time-s', $humanFormat)
    {

        if (preg_match('/\s+/', $date)) {
            list($date, $time) = explode(' ', $date);
        }

        if (!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $date)) {
            return $date;
        }

        list($year, $month, $day) = explode('-', $date);

        switch ($humanFormat) {
            case 'Y-m-d':
                $return = "{$year}-{$month}-{$day}";
                break;

            case 'Y.m.d':
                $return = "{$year}.{$month}.{$day}";
                break;

            case 'Y/m/d':
                $return = "{$year}/{$month}/{$day}";
                break;

            case 'd-m-Y':
                $return = "{$day}-{$month}-{$year}";
                break;

            case 'd.m.Y':
                $return = "{$day}.{$month}.{$year}";
                break;

            case 'd/m/Y':
                $return = "{$day}/{$month}/{$year}";
                break;

            default:
                $return = null;
                break;
        }

        if ($type === 'time-s') {
            return substr($time, 0, 5);

        } else if (in_array($type, array('date|datetime|time|time-s', 'datetime'))) {
            return $return . (isset($time) ? ' ' . $time : null);

        // Date time without seconds (Y m d H:i)
        } else if (in_array($type, array('datetime-s'))) {
            return $return . (isset($time) ? ' ' . substr($time, 0, 5) : null);

        // Date (Y m d)
        } else if ($type == 'date') {
            return $return;
        } else {
            return (isset($time) ? ' ' . $time : null);
        }
    }

    public static function daysBetweenTwoDates($date1, $date2)
    {
        $d1 = new \DateTime($date1);
        $d2 = new \DateTime($date2);
        $interval = $d1->diff($d2);
        return $interval->format("%r%a");
    }

    public static function monthsBetweenTwoDates($date1, $date2)
    {
        $d1 = new \DateTime($date1);
        $d2 = new \DateTime($date2);
        return $d1->diff($d2)->m;
    }

}
