<?php
/*
 * This file is part of the Loop-Framework package.
 *
 * (c) Luis Alberto <albertoluis0108@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LoopFM\Lib\Numbers;

/**
 * Class Numbers
 *
 * Class that handles numbers
 *
 * @package LoopFM\Lib\Numbers
 */
class Numbers
{
    public function positiveNumber($number)
    {
        return is_numeric($number) && $number > 0;
    }
}