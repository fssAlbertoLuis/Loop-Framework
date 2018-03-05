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


/**
 * Class with functions to validate various image atributes
 * Class ValidateImage
 * @package LoopFM\Lib\Image
 */
class ValidateImage
{
    private $image;

    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    public function maxSize($size)
    {
        return $this->image->getSize() < $size;
    }

    public function minSize($size)
    {
        return $this->image->getSize() > $size;
    }

    public function validExtensions(array $ext)
    {
        return in_array($this->image->getExtension(), $ext);
    }

    public function validType(array $types)
    {
        return in_array($this->image->getType(), $types);
    }

    public function getImage()
    {
        return $this->image;
    }
    public function randomizeName()
    {
        $a = date('Y-m-d H:i:s');
        $b = $this->image->getName();
        return md5($a.$b);
    }
}