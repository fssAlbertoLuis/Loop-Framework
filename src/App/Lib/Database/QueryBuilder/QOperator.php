<?php
/*
 * This file is part of the Loop-Framework package.
 *
 * (c) Luis Alberto <albertoluis0108@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LoopFM\Lib\Database\QueryBuilder;


/**
 * Class QOperator
 * Class with a collection of constants with the respectives operators of the syntax from
 * the currently using DB
 * @package LoopFM\Lib\Database\QueryBuilder
 */
class QOperator
{
    private function __construct() {}
    private function __clone() {}

    const EQUAL = "=";
    const NOT_EQUAL = "!=";
    const LESS = "<";
    const GREATER = ">";
    const LESS_EQUAL = "<=";
    const GREATER_EQUAL = ">=";
    const LIKE = "LIKE";
    const _AND_ = "AND";
    const _OR_ = "OR";
}