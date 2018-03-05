<?php
/*
 * This file is part of the Loop-Framework package.
 *
 * (c) Luis Alberto <albertoluis0108@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LoopFM\Lib\Strings;


/**
 * Class String
 * Class with utils for strings
 * @package LoopFM\Lib\Strings
 */
class _String
{
    private $string;

    /**
     * String constructor.
     * @param $string
     */
    public function __construct($string)
    {
        $this->string = $string;
    }

    /**
     * @param null $ext - add a suffix if needed, like an extension or unique identifier
     * return $string
     */
    public function randomize($ext=null)
    {
        $new = md5($this->string.rand(1,1000));
        return $new;
    }

    public function camelCase($ucFirst = false)
    {
        $r = str_replace('_', '', ucwords($this->string, '_'));
        if ($ucFirst)
            return ucfirst($r);
        else
            return $r;
    }
}