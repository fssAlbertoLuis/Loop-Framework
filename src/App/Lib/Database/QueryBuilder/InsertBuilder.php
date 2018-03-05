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
 * A QueryBuilder helper class which generates insert sql
 * Class InsertBuilder
 * @package LoopFM\Lib\Database\QueryBuilder
 */
class InsertBuilder
{
    private $params,
            $multiple_values;

    /**
     * InsertBuilder constructor.
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
        $this->multiple_values = !empty($params[0]) ? true : false;
    }

    /**
     * Generates column part of insert query, autoremove : if it exists
     * @return string
     */
    public function generateColumn()
    {
        $params = $this->params;
        if ($this->multiple_values) {
            $params = $this->params[0];
        }
        $columns = '(';
        if ($this->paramsHasValues()) {
            foreach ($params as $index => $value) {
                $columns .= trim($index, ':'). ',';
            }
        } else {
            foreach ($params as $param) {
                $columns .= trim($param, ':'). ',';
            }
        }
        return trim($columns,',').')';
    }

    /**
     * Generates values part of query, MUST have : in the beginning of column names
     * @return string
     */
    public function generateValues()
    {
        if ($this->multiple_values) {
            return $this->generateMultipleValues();
        } else {
            $columns = '(';
            if ($this->paramsHasValues()) {
                foreach ($this->params as $index => $value) {
                    $columns .= $index. ',';
                }
            } else {
                foreach ($this->params as $param) {
                    $columns .= $param. ',';
                }
            }
            return trim($columns, ',').')';
        }
    }

    public function generateMultipleValues()
    {
        $columns = '';
        foreach ($this->params as $params) {
            $columns .= '(';
            if ($this->paramsHasValues($params)) {
                foreach ($params as $index => $value) {
                    $columns .= '?,';
                }
                $columns = trim($columns, ',') . '),';
            } else {
                foreach ($params as $param) {
                    $columns .= '?,';
                }
                $columns = trim($columns, ',') . '),';
            }
        }

        return trim($columns, ',');
    }

    /**
     * This function check if the passed array in constructor is an array of COLUMNS only, like: [':col1', ':col2']
     * or if is an array of columns as indexes and values, like: [':col1' => 'value1', ':col2' => 'value2']
     * @return bool
     */
    private function paramsHasValues($params = null)
    {
        $params_compare = $params ? $params : $this->params;
        foreach ($params_compare as $index => $value) {
            return ctype_digit($index) === false;
        }
    }
}