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
 * Ajax
 *
 *
 * @package    Loop Sandbox Framework
 * @author     Luis Alberto <albertoluis0108@gmail.com>
 */

class Ajax
{
    private function __construct() {}
    private function __clone(){}

    /**
    *
    * @ Checa se é um request xmlhttprequest (Asynchronous)
    *
    * @return boolean
    *
    */
    public static function request()
	{
        return (
			!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
			strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
		);
    }
}
