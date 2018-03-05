<?php
/*
 * This file is part of the Loop-Framework package.
 *
 * (c) Luis Alberto <albertoluis0108@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace LoopFM\Lib\Interfaces;


/**
 * Dictates essential method for a validation service
 * Interface ValidateService
 * @package Syscam\Interfaces
 */
interface ValidateService
{
    public function validateFields();
    public function getErrors();
    public function getValidData();
}