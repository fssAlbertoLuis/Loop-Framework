<?php
/*
 * This file is part of the Loop-Framework package.
 *
 * (c) Luis Alberto <albertoluis0108@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LoopFM\Lib\Image;

use LoopFM\Lib\Strings\_String;


/**
 * Class Image
 * Encapsulates php image attributes
 * @package LoopFM\Lib\Image
 */
class Image
{
    private $type,
            $extension,
            $name,
            $tmp_file,
            $error,
            $size;

    public function __construct(array $file)
    {
        $this->name = $file['name'];
        $this->tmp_file = $file['tmp_name'];
        $this->error = $file['error'];
        $this->size = $file['size'];
        $this->setTypeExtension($file['type']);
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getTmpFile()
    {
        return $this->tmp_file;
    }

    /**
     * @param mixed $tmp_file
     */
    public function setTmpFile($tmp_file)
    {
        $this->tmp_file = $tmp_file;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param mixed $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * split $_FILE['type'] apart and defines the real type and the extension
     * @param $string
     */
    private function setTypeExtension($string)
    {
        $string = explode('/',$string);
        $this->type = $string[0];
        $this->extension = !empty($string[1]) ? $string[1] : null;
    }

    /**
     * @return mixed
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param mixed $extension
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    public function randomizeName()
    {
        $string = new _String($this->name);
        return $string->randomize();
    }

}