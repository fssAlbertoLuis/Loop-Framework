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
 * Class WhereBuilder
 * Has methods to generate the WHERE clause of a query
 * @package LoopFM\Lib\Database\QueryBuilder
 */
class WhereBuilder
{
    private $query;

    /**
     * WhereBuilder constructor.
     */
    public function __construct()
    {
        $this->query = "";
    }

    /**
     * Takes a column name and compares with a value. The value must be an index of an array of avalues
     * to be used in pdo execute(), like : ":value"
     * Then add the comparative clause to the query attribute.
     * @param string $column
     * @param string $compare_value
     * @param string $type - USE THE STATIC QOperator class to avoid compatibility issues in the future
     * @params string $operator - AND or OR - USE THE STATIC QOperator class to avoid compatibily issues in the
     * future
     */
    public function comparativeClause($column, $compare_value, $type, $operator=null)
    {
        try {
            $operator = $operator ? $operator : "";
            $this->query .= $column ." ". $type ." ". $compare_value." ".$operator." ";
        } catch (\Exception $e) {
            return "";
        }
    }

    /**
     * Generate between clause
     * @param string $column
     * @param string $compare_value
     * @param string $type - USE THE STATIC QOperator class to avoid compatibility issues in the future
     * @params string $operator - AND or OR - USE THE STATIC QOperator class to avoid compatibily issues in the future
     */
    public function betweenClause($column, $from, $to, $operator)
    {
        try {
            $operator = $operator ? $operator : "";
            $this->query .= $column ." BETWEEN ". $from ." AND ". $to." ".$operator." ";
        } catch (\Exception $e) {
            return "";
        }
    }

    /**
     * Return generated where clause
     * @return string
     */
    function getWhereClause()
    {
        return trim($this->query," AND  OR ");
    }
}