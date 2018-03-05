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


use LoopFM\Lib\Factories\Factory;

/**
 * Static class with current image types supported by the image factory
 * Class ImageType
 * @package LoopFM\Lib\Image
 */
class ImageType
{
    const BASE64 = 1,
          BINARY = 2;
}

/**
 * Creates image from post or base 64 - use the static type class ImageType to prevent
 * incompatibilities
 * Class ImageFactory
 * @package LoopFM\Lib\Image
 */
class ImageFactory extends Factory
{
    public function create(array $image)
    {
        switch ($this->type) {
            case ImageType::BASE64:
                return new Image64($image);
            default:
                return new Image($image);
        }
    }
}