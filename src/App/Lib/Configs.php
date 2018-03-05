<?php
/*
 * This file is part of the Loop-Framework package.
 *
 * (c) Luis Alberto <albertoluis0108@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace LoopFM\Lib;

/**
 * Class Configs
 *
 * Class which loads config file
 *
 * @package LoopFM\Lib\Strings
 */
class Configs
{
    private function __clone(){}

    private function __construct(){}

    public static function parseConfigFile($file)
    {
        return parse_ini_file($file, true);
    }
}
