<?php
/*
 * This file is part of the Loop-Framework package.
 *
 * (c) Luis Alberto <albertoluis0108@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace LoopFM\Lib\Mappers;


use LoopFM\Lib\Database\DBColumnUtils;
use LoopFM\Lib\Database\QueryBuilder\QOperator;
use LoopFM\Lib\Database\QueryBuilder\QueryBuilder as newQB;
use LoopFM\Lib\Database\QueryBuilder\QueryType;
use LoopFM\Lib\Database\QueryBuilder;
use LoopFM\Lib\Logger\Logger;


/**
 * Class Mapper
 *
 * Class which encapsulates basic pdo database commands
 *
 * @package LoopFM\Lib\Mappers
 */
class Mapper
{
    protected $db,
              $last_id,
              $prefix = '',
              $table;

    /**
     * @param $db
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Insert a row in database
     * @param $table
     * @param $params
     * @return bool
     */
    public function insert($table, $params)
    {
        try {
            $query_builder = new newQB(QueryType::INSERT_QUERY);
            $query_builder->insert($table);
            $query_builder->columns($params);
            $okokokok=false;
            if (!empty($params[0])) {
                $query_builder->values($params);
                $okokokok=true;
            } else {
                $query_builder->values($params);
            }

            $query = $query_builder->getQuery();

            if ($okokokok) {
                var_dump($query);die(var_dump($params));
            }
            $stmt = $this->db->prepare($query);
            $data = $stmt->execute($params);
            $this->last_id = $this->db->lastInsertId();
            return $data;
        } catch (\PDOException $e) {
            $log = new Logger('syscam');
            $log->create($e->getMessage(), $e->getFile(), $logType=2);
            return false;
        }
    }

    /**
     * Multiple insert in same query
     * @param $table
     * @param $params - Should be a multidimensional array [][]
     * @return bool
     */
    public function multipleInsert($table, $params)
    {
        try {
            $db_utils = new DBColumnUtils();
            $query_builder = new newQB(QueryType::INSERT_QUERY);
            $query_builder->insert($table);
            $query_builder->columns($params);
            $query_builder->values($params);

            $query = $query_builder->getQuery();

            $merge_params = $db_utils->paramBindArray($params);
            $stmt = $this->db->prepare($query);
            $data = $stmt->execute($merge_params);
            $this->last_id = $this->db->lastInsertId();
            return $data;
        } catch (\PDOException $e) {
            $log = new Logger('syscam');
            $log->create($e->getMessage(), $e->getFile(), $logType=2);
            return false;
        }
    }

    /**
     * Select a row from a table in database
     * @param $table
     * @param null $params
     * @param null $columns
     * @param null $options
     * @return array|null
     */
    public function select($table, $params=null, $columns=null, $options=null)
    {
        if (!$columns) {
            $columns = "*";
        }
        try {
            $data = null;
            $query_builder = new QueryBuilder($params);
            $query_builder->generateWhereQuery();
            $where = $query_builder->getWhereQuery();
            $stmt = $this->db->prepare(
                "SELECT {$columns} FROM {$table} {$where} {$options}"
            );
            $stmt->execute($query_builder->getQueryParams());
            $data = $stmt->fetch();
            $db_utils = new DBColumnUtils;
            $data = $db_utils->removeDbPrefix($data, $this->prefix);
            return $data;
        } catch (\PDOException $e) {
            $log = new Logger('syscam');
            $log->create($e->getMessage(), $e->getFile(), $logType=2);
            return null;
        }
    }

    /**
     * UPDATE command
     * @param $table
     * @param $edit
     * @param $params
     * @return bool
     */
    public function edit($table, $edit, $params)
    {
        try {
            $query_builder = new newQB(QueryType::UPDATE_QUERY);
            $query_builder->update($table);
            $query_builder->set($edit);
            foreach ($params as $p => $v) {
                if (next($params) === false) {
                    $query_builder->whereEquals(trim($p, ':'), $p);
                } else {
                    $query_builder->whereEquals(trim($p, ':'), $p, QOperator::_AND_);
                }

            }

            $query = $query_builder->getQuery();
            $stmt = $this->db->prepare($query);
            if ($stmt->execute(array_merge($edit, $params))) {
                return true;
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            $log = new Logger('syscam');
            $log->create($e->getMessage(), $e->getFile(), $logType=2);
            return false;
        }
    }

    /**
     * Retrieve multiple rows from a table, if possible
     * @param $table
     * @param null $params
     * @param null $columns
     * @param null $options
     * @param array $search
     * @return array|null
     */
    public function _list($table, $params=null, $columns=null, $options=null, $search=[])
    {
        if (!$columns) {
            $columns = "*";
        }
        try {
            $data = null;
            $query_params = null;
            $query = "SELECT {$columns} FROM {$table}";
            if ($params) {
                $query_builder = new QueryBuilder($params, $search);
                $query_builder->generateWhereQuery();
                $where = $query_builder->getWhereQuery();
                $query = "SELECT {$columns} FROM {$table} {$where} {$options}";
                $query_params = $query_builder->getQueryParams();
            }

            $stmt = $this->db->prepare($query);
            if ($query_params)
                $stmt->execute($query_params);
            else
                $stmt->execute();
            $data = $stmt->fetchAll();
            $db_utils = new DBColumnUtils;
            $data = $db_utils->removeDbPrefix($data, $this->prefix);
            return $data;
        } catch (\PDOException $e) {
            $log = new Logger('syscam');
            $log->create($e->getMessage(), $e->getFile(), $logType=2);
            return null;
        }
    }

    /**
     * DELETE command
     * @param $table
     * @param $params
     * @return bool
     */
    public function delete($table, $params)
    {
        $query_builder = new newQB();
        $query_builder->delete($table);
        foreach ($params as $p => $v) {
            if (next($params) === false) {
                $query_builder->whereEquals(trim($p, ':'), $p);
            } else {
                $query_builder->whereEquals(trim($p, ':'), $p, QOperator::_AND_);
            }
        }

        $stmt = $this->db->prepare($query_builder->getQuery());
        return $stmt->execute($params);
    }

    /**
     * @return int|null
     */
    public function getLastInsertedId()
    {
        return $this->last_id;
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param string $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }
}