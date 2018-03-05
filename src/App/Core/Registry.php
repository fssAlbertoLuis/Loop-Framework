<?php
/*
 * This file is part of the Loop-Framework package.
 *
 * (c) Luis Alberto <albertoluis0108@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LoopFM\Core;

/**
 * Registry
 *
 * @package    Loop-Framework
 * @author     Luis Alberto <albertoluis0108@gmail.com>
 */

class Registry
{
    /**
    * var vector
    * @ accesso private
    */
	private $vars = array();


    /**
    *
    *
    * @param string $index
    *
    * @param mixed $valor
    *
    * @return void
    *
    */
    public function __set($index, $valor)
    {
        $this->vars[$index] = $valor;
    }

    /**
    *
    *
    * @param mixed $index
    *
    * @return mixed
    *
    */
    public function __get($index)
    {
        return $this->vars[$index];
    }
}
