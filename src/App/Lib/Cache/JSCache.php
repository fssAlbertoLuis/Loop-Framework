<?php
/*
 * This file is part of the Loop-Framework package.
 *
 * (c) Luis Alberto <albertoluis0108@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LoopFM\Lib\Cache;


use LoopFM\Lib\Extensions\ValidateExtensions;
use \MatthiasMullie\Minify;

/**
 * Caching js files
 * Class JSCache
 * @package LoopFM\Lib\Cache
 */
class JSCache
{
    /**
     *
     * Caches all js files into one minified file, utilizes Minifier
     *
     * @param array
     *
     * @param string $to - file to save
     *
     * @return boolean
     *
     */
    public static function shrinkFiles(array $filelist, $to)
    {
        if (!file_exists($to)) {
            $content = '';
            foreach ($filelist as $file) {
                if (!ValidateExtensions::permittedExtensions($file, ['js']))
                    die('Invalid extension "'.$file.'" in: Cache::js_files');
                $content .= file_get_contents($file);
            }
            $minifier = new Minify\JS($content);
            $minifier->minify($to);
            return true;
        }
    }
}