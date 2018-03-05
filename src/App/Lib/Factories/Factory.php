<?php
/*
 * This file is part of the Loop-Framework package.
 *
 * (c) Luis Alberto <albertoluis0108@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LoopFM\Lib\Factories;


/**
 * Class Factory
 * Base class for factory of classes
 * @package LoopFM\Lib\Factories
 */
abstract class Factory
{
    protected $type;

    /**
     * takes user type param
     * @param $type
     */
    public function __construct($type = 1)
    {
        $this->type = $type;
    }

    /**
     * Main factory class, which instantiates classes accordingly
     * @param $data
     */
    abstract public function create(array $data);
}