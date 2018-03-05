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


class DBColumnUtils
{
    /**
     * @param array $data
     * @param string $prefix
     * @return array|null
     * Remove a prefix from a column (an key from array). Ideal if database columns have
     * some sort of prefix, but code doesn't use one.
     */
    public function removeDbPrefix($data, $prefix)
    {

        if (is_array($data)) {
            $new_data = [];

            if (!empty($data[0])) {
                foreach ($data as $d) {
                    $new_data[] = $this->removeDbPrefix($d, $prefix);
                }
            } else {
                foreach ($data as $i => $v) {
                    $i = str_replace($prefix, '', $i);
                    $new_data[$i] = $v;
                }
            }
            return $new_data;
        } else {
            $data = str_replace($prefix, '', $data);
            return $data;
        }
    }

    /**
     * @param array $data
     * @param string $prefix
     * @return array|string
     * add a prefix to an array keys
     */
    public function addDbPrefix($data, $prefix)
    {
        if (is_array($data)) {
            $new_data = [];
            foreach ($data as $i => $v) {
                $i = $prefix.$i;
                $new_data[$i] = $v;
            }
            return $new_data;
        } else {
            $data = $prefix.$data;
            return $data;
        }
    }

    /**
     * Returns a simple array from a multidimensional array to be used in binding statements with ?
     * @param array $arr
     * @return array
     */
    public function paramBindArray(array $arr)
    {
        $a = [];
        if (!empty($arr[0])) {
            foreach ($arr as $p) {
                $a = array_merge($a, array_values($p));
            }
            return $a;
        }
        return $a;
    }
}