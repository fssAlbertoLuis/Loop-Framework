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
 * Class QueryBuilder
 * Build query based on sql drivers syntax
 * @package LoopFM\Lib\Database\QueryBuilder
 */

class QueryBuilder
{
    private $insert,
            $columns,
            $values,
            $select,
            $from,
            $where,
            $options,
            $groups,
            $type,
            $union;

    function __construct($type=0)
    {
        $this->type = $type;
        $this->where = "";
        $this->values = "VALUES ";
        $this->set = "";
        $this->union = "";
        $this->update = "";
        $this->delete = "";
    }

    /**
     * Creates starting delete query
     * @param $table
     */
    public function delete($table)
    {
        $this->select = "DELETE FROM ".$table;
    }
    /**
     * Creates starting insert query
     * @param $table
     */
    public function insert($table)
    {
        $this->insert = "INSERT INTO ".$table;
    }

    /**
     * Creates starting UPDATE query
     * @param $table
     */
    public function update($table)
    {
        $this->update = "UPDATE ".$table;
    }

    /**
     * creates SET part of update query
     * @param array $data
     */
    public function set(array $data)
    {
        $this->set = ' SET';
        foreach ($data as $i => $v) {
            $this->set .=  ' '. trim($i, ':') . ' = '. $i . ',';
        }
        $this->set = trim($this->set, ','). ' ';
    }
    /**
     * Creates the column part of insert query
     * @param string $string - pass the string of columns, like: "(id, name, age, etc)"
     */
    public function columns($string)
    {
        if (is_array($string)) {
            $insert_builder = new InsertBuilder($string);
            $this->columns = $insert_builder->generateColumn();
        } else {
            $this->columns = $string;
        }
    }

    /**
     * Creates the VALUES part of insert query
     * @param string $string - pass the string with the values in the PDO way, like: "(:id, :name, :age, :etc)"
     */
    public function values($string)
    {
        if (is_array($string)) {
            $insert_builder = new InsertBuilder($string);
            $this->values .= $insert_builder->generateValues();
        } else {
            $this->values = $string;
        }
    }

    /**
     * @param string $columns
     */
    function select($columns)
    {
        $this->select = "SELECT ".$columns;
    }

    /**
     * @param string $table
     */
    function from($table)
    {
        $this->from = " FROM ".$table;
    }

    /**
     * @param $column
     * @param $index
     * @param $type - AND or OR operators, USE QOperator static class to avoid compatibility issues. Note: only let it
     * null if this is the last comparation in the query
     * @param null|String $group - this will group in parethesis comparations of the same group.
     * Ex: $group = 'group1', members of group1 will be agrouped according to its respectives operators(AND or OR)
     * inside same parenthesis. So, group1 and group2 would be: (comparations_of_group_1) OR (comparations_of_group_2)
     */
    function whereEquals($column, $index, $type=null, $group=null)
    {
        $and_or = ($type ? $type : "");
        $where_builder = new WhereBuilder();
        $where_builder->comparativeClause($column, $index, QOperator::EQUAL);
        $string = $where_builder->getWhereClause();
        $this->where .= $string." ".$and_or." ";
    }

    /**
     * @param $column
     * @param $index
     * @param $type - AND or OR operators, USE QOperator static class to avoid compatibility issues. Note: only let it
     * null if this is the last comparation in the query
     * @param null|String $group - this will group in parethesis comparations of the same group.
     * Ex: $group = 'group1', members of group1 will be agrouped according to its respectives operators(AND or OR)
     * inside same parenthesis. So, group1 and group2 would be: (comparations_of_group_1) OR (comparations_of_group_2)
     */
    function whereLike($column, $index, $type=null, $group=null)
    {
        $and_or = ($type ? $type : "");
        $where_builder = new WhereBuilder();
        $where_builder->comparativeClause($column, $index, QOperator::LIKE);
        $string = $where_builder->getWhereClause();
        $this->where .= $string." ".$and_or." ";
    }

    /**
     * Takes an array of queries and recreates it in an UNION query
     * @param array $queries
     */
    function union(array $queries, $type) {
        $union_word = " UNION ".$type." ";
        foreach ($queries as $q) {
            $this->union .= $q.$union_word;
        }
        $this->union = trim($this->union, $union_word);
        $this->type = 3;
    }

    function getQuery()
    {
        if ($this->type == QueryType::INSERT_QUERY) {
            return $this->insert.' '.$this->columns.' '.$this->values;
        } else {
            $this->where = !empty($this->where) ? "WHERE ".$this->where : "";
            switch ($this->type) {
                case QueryType::SUB_QUERY:
                    return "(".trim($this->select." ".$this->from." ".$this->where." ".$this->options).")";
                    break;

                case QueryType::UNION_QUERY:
                    return $this->union;
                    break;

                case QueryType::UPDATE_QUERY:
                    return $this->update.$this->set.$this->where;
                    break;

                default:
                    return $this->select." ".$this->from." ".$this->where." ".$this->options;
                    break;
            }
        }
    }

    /**
     * Take string and add to the WHERE clause
     * WARNING: any previous where clauses using the partial methods will be deleted!
     * @param string $where
     */
    function where($where)
    {
        $this->where = "";
        $this->where = $where;
    }

    /**
     * Set the option part of query from a string
     * WARNING: any previous option clauses using the partial methods will be deleted!
     * @param string $options
     */
    function options($options)
    {
        $this->options = "";
        $this->options = $options;
    }
}