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

class Post
{

    private function __construct() {}

    /**
     * Check if a post exists
     * @return bool
     */
    public static function exists()
    {
        return !empty($_POST);
    }

    /**
     * check if post has a especific index
     * @param $index
     * @return bool
     */
    public static function has($index)
    {
        return !empty($_POST[$index]);
    }

    /**
     * Get a post value
     * @param null $index - if null, get all post
     * @return null
     */
    public static function get($index=null)
    {
        if($index) {
            return !empty($_POST[$index]) ? $_POST[$index] : null;
        }
        return $_POST;
    }

    /**
     * get array of post based on array param
     * @param $index - if array, get array of posts, if not, get index of post
     * @return array
     */
    public static function getOnly($index) {
        if (is_array($index)) {
            $arr = [];
            try {
                foreach ($index as $k) {
                    $arr[$k] = $_POST[$k];
                }
            } catch(Exception $e) {
                echo $e;
            }
            return $arr;
        }
        else
            return $_POST[$index];
    }

    /**
     * get all except array of index issued
     * @param $exception
     * @return array
     */
    public static function getExcept($exception)
    {
        $new_array = [];
        if (is_array($exception)) {
            foreach ($_POST as $postName => $value)
                if(!in_array($postName, $exception))
                    $new_array[$postName] = $value;
        } else {
            foreach ($_POST as $postName => $value)
                if($postName != $exception)
                    $new_array[$postName] = $value;
        }
        return $new_array;
    }

    /**
     * remove a post
     * @param $k
     */
    public static function remove($k)
    {
        unset($_POST[$k]);
    }

    /**
     * var dumps post
     */
    public static function dump()
    {
        return var_dump($_POST);
    }
}
