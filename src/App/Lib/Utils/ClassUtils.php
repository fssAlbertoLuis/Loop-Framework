<?php
/*
 * This file is part of the Loop-Framework package.
 *
 * (c) Luis Alberto <albertoluis0108@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LoopFM\Lib\Utils;


/**
 * Class with utility methods for checking and handling classes and classes elements. Make use
 * of php class methods and reflection api
 * Class ClassUtils
 * @package LoopFM\Lib\Utils
 */
class ClassUtils
{

    /**
     * Check if a property exists inside a class
     * @param $class
     * @param string | array $property
     * @return bool
     */
    public static function hasProperty($class, $property)
    {
        $has = true;
        if (is_array($property)) {
            foreach ($property as $l) {
                if (!property_exists($class, $l)) {
                    $has = false;
                    break;
                }
            }
        } else property_exists($class, $property);
        return $has;
    }

    /**
     * Check class has any of the properties especified in a list of strings
     * @param $class
     * @param array $property
     * @return bool
     */
    public static function hasAnyProperty($class, array $property)
    {
        $has = false;
        foreach ($property as $l) {
            if (property_exists($class, $l)) {
                $has = true;
                return true;
            }
        }
        return $has;
    }
}