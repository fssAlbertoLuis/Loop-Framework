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
 * Interface for checking updated values for updating databases
 * Interface UpdateService
 * @package Syscam\Interfaces
 */
interface UpdateService
{
    /**
     * Must pass old value
     * UpdateService constructor.
     * @param $old_value
     */
    public function __construct($old_value);

    /**
     * Must pass new values to compare with old value
     * @param $new_values
     * @return mixed
     */
    public function compareValues($new_values);

    /**
     * simple getter for updated values
     * @return mixed
     */
    public function getUpdatedValues();
}