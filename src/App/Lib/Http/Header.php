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


class Header
{
    /**
     * @param $name
     * @return null
     *
     * Get a request value from header
     */
    public static function request($name) {
        $headers = apache_request_headers();
        return !empty($headers[$name]) ? $headers[$name] : null;
    }

    /**
     * @param null $url
     *
     * redirect to a chosen location
     */
    public static function location($url=null) {
        if (!$url) {
            $url = '/';
        }
        header('Location: '.$url);
        die();
    }

    /**
     * The string of the header to be sent
     * @param $header - can receive a constant of static class StatusCode
     */
    public static function send($header)
    {
        header($header);
    }

    public static function get($header_name)
    {

    }
}