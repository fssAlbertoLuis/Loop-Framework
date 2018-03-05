<?php
/*
 * This file is part of the Loop-Framework package.
 *
 * (c) Luis Alberto <albertoluis0108@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LoopFM\Lib\Object;

use LoopFM\Lib\Object\Exceptions\ObjectUpdaterException;

/**
 * Class ObjectUpdater
 *
 * Class which check for updates on same object
 *
 * @package LoopFM\Lib\Object
 */
class ObjectUpdater
{
    private $updated_values,
            $old_obj,
            $class_name;

    function __construct($old_obj)
    {
        if (!is_object($old_obj)) {
            throw new ObjectUpdaterException("Must be an instance of a class");
        }
        $this->class_name = get_class($old_obj);
        $this->old_obj = $old_obj;
        $this->updated_values = [];
    }

    /**
     * Compares object specified in contructor with new object of same data
     * @param $new_obj
     * @throws ObjectUpdaterException
     */
    public function compare($new_obj)
    {
        if (!is_object($new_obj) || get_class($new_obj) !== $this->class_name) {
            throw new ObjectUpdaterException("All instances must be of same class");
        }

        $reflection = new \ReflectionClass($new_obj);
        $old_reflection = new \ReflectionClass($this->old_obj);
        foreach ($reflection->getProperties() as $prop) {
            $p = $reflection->getProperty($prop->name);
            $o = $old_reflection->getProperty($prop->name);
            $p->setAccessible(true);
            $o->setAccessible(true);
            $pvalue = $p->getValue($new_obj);
            $ovalue = $o->getValue($this->old_obj);
            if ($pvalue != NULL && $pvalue != $ovalue) {
                $this->updated_values[$prop->name] = $pvalue;
            }
        }
    }

    /**
     * Check if object has same name
     * @param $obj
     * @return string
     */
    public function check($obj) {
        return $this->class_name;
    }

    /**
     * @return array
     */
    public function getUpdatedValues()
    {
        return $this->updated_values;
    }
}