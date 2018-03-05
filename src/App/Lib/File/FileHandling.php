<?php
/*
 * This file is part of the Loop-Framework package.
 *
 * (c) Luis Alberto <albertoluis0108@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LoopFM\Lib\file;

use LoopFM\Lib\File\Exceptions\UnableToFindFilePathException;
use LoopFM\Lib\File\Exceptions\UnableToOpenFileException;

class FileHandling
{
    private $filepath,
            $file;

    /**
     * send the file location to open the file, or create it
     * @param $filepath
     */
    public function __construct($filepath) {
        $this->filepath = $filepath;
        $this->file = $this->open();
    }

    /**
     * close file on script execution
     */
    public function __destruct()
    {
        if ($this->file) {
            $this->close();
        }
    }

    /**
     * return opened file
     * @return resource
     */
    public function open()
    {
        if (!file_exists(dirname($this->filepath))) {
            throw new UnableToFindFilepathException("O caminho '{$this->filepath}' especificado não existe.");
        }
        try {
            return fopen($this->filepath, 'a');
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * close file if it's open
     */
    public function close()
    {
        if ($this->file) {
            fclose($this->file);
        }
    }

    public function write($content)
    {
        if ($this->file) {
           fwrite($this->file, trim($content).PHP_EOL);
        } else throw new UnableToOpenFileException("The file '{$this->filepath}' is not opened.");
    }
    /**
     * @return string
     */
    public function getFilepath()
    {
        return $this->filepath;
    }

    /**
     * @param string $filepath
     */
    public function setFilepath($filepath)
    {
        $this->filepath = $filepath;
    }
}