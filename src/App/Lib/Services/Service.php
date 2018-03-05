<?php
/*
 * This file is part of the Loop-Framework package.
 *
 * (c) Luis Alberto <albertoluis0108@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LoopFM\Lib\Services;

/**
 * Class ServiceException
 *
 * Abastract class for services in model
 *
 * @package LoopFM\Lib\Services
 */
class ServiceException extends \Exception {}

abstract class Service
{

    protected $db;
    /**
     * @param $db - database instance
     * the constructor
     */
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }
}