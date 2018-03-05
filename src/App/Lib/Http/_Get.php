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


class _Get
{
    private function __construct() {}

    /**
     * @param $index
     * @return bool
     * Check if get var has ANY of the given array of indexes
     */
    public static function hasAny($index)
    {
        if (is_array($index)) {
            foreach ($_GET as $i => $v) {
                if ($i != 'rt' && in_array($i, $index)) {
                    return true;
                }
            }
            return false;
        } else {
            return self::has($index);
        }
    }

    /**
     * @param $index
     * @return bool
     * check if get var has ALL indexes of a given array
     */
    public static function hasAll($index)
    {
        if (is_array($index)) {
            foreach ($_GET as $i => $v) {
                if ($i != 'rt' && !in_array($i, $index)) {
                    return false;
                }
            }
            return true;
        } else {
            return self::has($index);
        }
    }

    /**
     * @param $index
     * @return bool
     * Check if get var has index
     */
    public static function has($index)
    {
        return !empty($_GET[$index]);
    }

    /**
     * @param null $index
     * @return array|null
     * Get all indexes of get var, or get an specific/array of indexes. Note that
     * requesting an array of indexes will return only vars that exists
     */
    public static function get($index=null)
    {
        if($index) {
            if (is_array($index)) {
                $arr = [];
                foreach ($index as $i) {
                    if (!empty($_GET[$i])) {
                        $arr[$i] = $_GET[$i];
                    }
                }
                return $arr;
            } else {
                return !empty($_GET[$index]) ? $_GET[$index] : null;
            }
        }
        return $_GET;
    }

    /**
     * @param $exception
     * @return array
     * Get all, except an index or an array of indexes from get var
     */
    public static function getExcept($exception)
    {
        $new_array = [];
        if (is_array($exception)) {
            foreach ($_GET as $postName => $value)
                if(!in_array($postName, $exception))
                    $new_array[$postName] = $value;
        } else {
            foreach ($_GET as $postName => $value)
                if($postName != $exception)
                    $new_array[$postName] = $value;
        }
        return $new_array;
    }

    /**
     * @param $k
     * remove var
     */
    public static function remove($k)
    {
        unset($_GET[$k]);
    }

    /**
     * dump get var contents
     */
    public static function dump()
    {
        return var_dump($_GET);
    }
}