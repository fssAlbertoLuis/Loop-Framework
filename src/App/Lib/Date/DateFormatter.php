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

/**
 * Class DateFormatter - For handling various date formats
 * @package LoopFM\Lib\date
 */
class DateFormatter
{
    /**
     * Format a valid Y-m-d H:i:s date to a desired valid format. If bad format, default to null date: 0000-00-00 00:00:00
     * @param $date
     * @param $format
     * @return DateTime|string
     */
    public function format($date, $format)
    {
        try {
            $formatted = new DateTime($date);
            $formatted = $formatted->format($format);
            return $formatted;
        } catch (\Exception $e) {

            return '0000-00-00 00:00:00';
        }
    }

    /**
     * Format date based on a custom format
     * @param string $from the original format
     * @param string $to the desired format
     * @param string $date date string
     * @return bool|DateTime|string
     */
    public function formatFromAny($from, $to, $date)
    {
        try {
            $formatted = DateTime::createFromFormat($from, $date);
            $formatted = $formatted->format($to);
            return $formatted;
        } catch (\Exception $e) {

            return '0000-00-00 00:00:00';
        }
    }
}