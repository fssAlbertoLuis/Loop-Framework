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
     * Send bad request error to header
     */
    public static function err400()
    {
        header('HTTP/1.0 400 Bad Request');
    }

    /**
     * Send unauthorized error to header
     */
    public static function err401()
    {
        header('HTTP/1.0 401 Unauthorized');
    }

    /**
     * Send forbidden error to header
     */
    public static function err403()
    {
        header('HTTP/1.0 403 Forbidden');
    }

    /**
     * Send Internal server error to header
     */
    public static function err500()
    {
        header('HTTP/1.0 500 Internal Server Error');
    }

    /**
     * Send 404 not found error to header
     */
    public static function err404()
    {
        header('HTTP/1.0 404 Not Found');
    }
}