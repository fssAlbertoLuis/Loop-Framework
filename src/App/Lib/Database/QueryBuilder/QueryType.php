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
 * Class QueryType
 * Static class which encapsulates query type strings
 * @package LoopFM\Lib\Database\QueryBuilder
 */
class QueryType
{
    const SUB_QUERY = 1;
    const INSERT_QUERY = 2;
    const UNION_QUERY = 3;
    const UPDATE_QUERY = 4;

    const UNION_ALL = 'ALL';
}