<?php
/*
 * This file is part of the Loop-Framework package.
 *
 * (c) Luis Alberto <albertoluis0108@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LoopFM\Lib\Http;


/**
 * Class that checks raw input from http requests
 * Class RawInput
 * @package LoopFM\Lib\Http
 */
class RawInput
{
    /**
     * Reads raw input from php and outputs into a var
     * @param string $format - The format of the data returned. can be: default (raw), json (return a class)
     * @return bool | mixed
     */
    public static function get($format = 'raw')
    {
        $data = file_get_contents('php://input');
        if ($data) {
            switch (strtolower($format)) {
                case 'json':
                    return json_decode($data);
                case 'array':
                    return json_decode($data, true);
                default:
                    return $data;
            }
        } else return null;
    }
}