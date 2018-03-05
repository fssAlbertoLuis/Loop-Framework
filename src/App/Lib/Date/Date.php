<?php
/*
 * This file is part of the Loop-Framework package.
 *
 * (c) Luis Alberto <albertoluis0108@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LoopFM\Lib\date;
use DateTime;

class Date
{
    /**
     * @param null $from - if null, defaults do date()
     * @param $to - Accepts only 'Y-m-d' formats
     * @return string
     */
    public function getDaysLeft($to, $from=null)
    {
        $from = !$from ? date('Y-m-d') : $from;
        if ($this->validateDate($to, 'Y-m-d')) {
            $to = new DateTime($to);
            $from = new DateTime($from);
            return $from->diff($to)->format('%r%a');
        } else {
            return null;
        }
    }

    public function countDays($to, $from=null)
    {
        if (!$from)
            $from = date('Y-m-d');
        $from = new \DateTime($from);
        $to = new \DateTime($to);
        $diff = $from->diff($to);
        return (int)$diff->format('%r%a');
    }

    /**
     * Check if a date is valid
     * @param $date
     * @param $format
     * @return bool
     *
     */
    public function validateDate($date, $format)
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    /**
     * @param $date
     * @param $days
     * @return string
     */
    public function addDays($date, $days)
    {
        $add_days = "P{$days}D";
        $date = new \DateTime($date);
        $date->add(new \DateInterval($add_days));
        return $date->format('Y-m-d H:i:s');
    }
}