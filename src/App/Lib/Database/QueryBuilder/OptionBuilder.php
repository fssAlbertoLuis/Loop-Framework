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
 * Class OptionBuilder
 * Generate the options clause of query
 * @package LoopFM\Lib\Database\QueryBuilder
 */
class OptionBuilder
{
    private $options,
            $limit;

    /**
     * Set limit part of query, setting offset if all parameters are filled
     * @param $limit
     * @param null $page
     */
    function setLimit($limit, $page=null)
    {
        try {
            if ($page) {
                $offset = ($page - 1) * $limit;
                $this->limit = "LIMIT {$offset},{$limit}";
            } else {
                $this->limit = "LIMIT{$limit}";
            }
        } catch (\Exception $e) {
            return;
        }
    }

    /**
     * Get string of options
     * @return string
     */
    function getOptions()
    {
        return $this->options." ".$this->limit;
    }
}