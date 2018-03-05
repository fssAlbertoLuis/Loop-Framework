<?php
/*
 * This file is part of the Loop-Framework package.
 *
 * (c) Luis Alberto <albertoluis0108@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LoopFM\Lib\session;


/**
 * Class Session
 * @package LoopFM\Lib\session
 * @author Luis Alberto <albertoluis0108@gmail.com>
 *
 * Wrapper class for $_SESSION
 */
class Session
{
    private function __cosctruct() {}

    /**
     * @param $key
     * @return bool
     */
    public static function has($key)
    {
        return array_key_exists($key, $_SESSION);
    }

    /**
     * @param $key
     * @param $val
     */
    public static function set($key, $val)
    {
        $_SESSION[$key] = $val;
    }

    /**
     * @param $key
     * @param mixed|false $default
     * @return mixed
     */
    public static function get($key, $default=false)
    {
        return (isset($_SESSION[$key]) ? $_SESSION[$key] : $default);
    }

    /**
     * @param $key
     * @param bool|false $default
     * @return mixed
     *
     * Get $_SESSION var once, then deletes it. Useful for redirect messages to be displayed only once
     */
    public static function getOnce($key, $default=false)
    {
        $val = self::get($key, $default);
        self::delete($key);
        return $val;
    }

    /**
     * @param $key
     */
    public static function delete($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Dump Session contents
     */
    public static function dump()
    {
        var_dump($_SESSION);
    }
}