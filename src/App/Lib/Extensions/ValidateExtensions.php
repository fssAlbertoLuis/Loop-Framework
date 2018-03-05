<?php
/*
 * This file is part of the Loop-Framework package.
 *
 * (c) Luis Alberto <albertoluis0108@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LoopFM\Lib\Extensions;


/**
 * Class that check various extensions
 * Class ValidateExtensions
 * @package LoopFM\Lib\Extensions
 */
class ValidateExtensions
{
    /**
     * Check if file has permitted extension from an array of extensions
     * @param $filename - filename with .extension_name in the end
     * @param array $extensions - array of extensions
     * @return bool
     */
    public static function permittedExtensions($filename, array $extensions)
    {
        $exp_file = explode('.', $filename);
        $extension = end($exp_file);
        return in_array(strtolower($extension), $extensions);
    }
}