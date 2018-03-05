<?php
/*
 * This file is part of the Loop-Framework package.
 *
 * (c) Luis Alberto <albertoluis0108@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LoopFM\Lib\database;


class QueryBuilder
{

    private $comparative_params,
            $search_params;
    private $where_query,
            $where_params;

    /**
     * QueryBuilder constructor.
     * @param array $comparative_params
     * @param array $search_params
     */
    public function __construct(array $comparative_params = [], array $search_params = [])
    {

        $this->comparative_params = $comparative_params;
        $this->search_params = $search_params;
        $this->where_query = '';
        $this->where_params = [];
    }

    /**
     * @param array $params
     * @return string - Format: "WHERE column = :column"
     * Creates a where string in pdo style. ONLY WITH AND's
     */
    public function generateWhereQuery()
    {
        $search_string = $this->generateSearchString();
        $comparative_string = $this->generateComparativeString();
        $this->mountQuery($comparative_string, $search_string);
    }

    /**
     * @param array $params
     * @return string
     * Generate comparative string
     */
    private function generateComparativeString()
    {
        $params = $this->comparative_params;
        foreach ($params as $p => $v) {
            $this->where_query .= trim($p, ':').' = ' . $p . ' AND ';
            $this->where_params[$p] = $v;
        }
        $this->where_query = trim($this->where_query, ' AND ');
        return $this->where_query;
    }

    /**
     * @param array $search
     * @return string
     * Generate search bit of query
     */
    private function generateSearchString()
    {
        foreach ($this->search_params as $s => $v) {
            if (is_array($v)) {
                $this->where_query .= $this->generateBetweenString($s, $v). ' AND ';
            } else {

                if ($this->isForeignSearch($s)) {
                    $this->generateForeignSearch($s, $v);
                } else {
                    $this->where_query .= trim($s, ':') . ' LIKE ' . $s . ' AND ';
                    $this->where_params[$s] = $v;
                }
            }
        }
        $this->where_query = trim($this->where_query, ' AND ');
        return (!empty($this->where_query) ? "{$this->where_query}" : "");
    }

    /**
     * @param $params
     * @param $search
     * @return string
     *
     * Mounts query based on filled strings
     */
    private function mountQuery($comparative, $search) {
        if ($this->where_query) {
            $this->where_query = 'WHERE '. $this->where_query;
        }
    }

    /**
     * Generate BETWEEN part of a query.
     * Usage: The value parte of param MUST be an array of at least one numeric index.
     * Ex: array('PARAM_NAME' => array(0 => VALUE_0, 1 => VALUE_1));
     * @param string $index - The index and the name of the column
     * @param array $v - the value, MUST BE AN ARRAY OF AT LEAST 1 NUMERIC INDEX
     * @return string
     */
    private function generateBetweenString($index, $v)
    {
        $from = $index.'0';
        $to = $index.'1';

        if (count($v) > 1) {
            $this->where_params[$from] = $v[0];
            $this->where_params[$to] = $v[1];
            $index = trim($index, ':');
            return "({$index} BETWEEN {$from} AND {$to})";
        } else {
            $signal = null;
            if (!empty($v[0])) {
                $this->where_params[$index] = $v[0];
                $signal = '>=';
            }
            if (!empty($v[1])) {
                $this->where_params[$index] = $v[1];
                $signal = '<=';
            }
            return "(". trim($index, ':') . " " . $signal . " ". $index .")";
        }
    }

    private function generateForeignSearch($index, $value) {
        $part = explode(':', $index);
        $table = $part[0];
        die(var_dump($index));
        return $string;
    }

    private function isForeignSearch($index)
    {
        return count(explode(':',$index)) > 1;
    }
    /**
     * @return array
     */
    public function getQueryParams()
    {
        return $this->where_params;
    }

    /**
     * @return string
     */
    public function getWhereQuery()
    {
        return $this->where_query;
    }
}