<?php
/*
 * This file is part of the Loop-Framework package.
 *
 * (c) Luis Alberto <albertoluis0108@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LoopFM\Lib\Logger;
use LoopFM\Lib\File\Exceptions\UnableToFindFilePathException;
use LoopFM\Lib\File\Exceptions\UnableToOpenFileException;
use LoopFM\Lib\File\FileHandling;


/**
 * Class Logger
 * Creates a log of activities from a model and stores it on a file of
 * any extension of choice
 * @package LoopFM\Lib\Logger
 * @author Luis Alberto <albertoluis0108@gmail.com>
 */
class Logger
{
    private $basepath = __PATH;

    private $logpath = "/src/logs";

    private $file_extension = "log";

    private $log_types = [
        0 => LogType::notice,
        1 => LogType::warning,
        2 => LogType::error
    ];

    private $model_name,
            $filepath;

    /**
     * Takes a model name to create the log file
     * @param $model
     * @param null $filepath
     */
    public function __construct($model_name, $filepath=null)
    {
        $this->model_name = $model_name;
        if (!$filepath) {
            $this->filepath = $this->resolveFilePath();
        } else {
            $this->filepath = $filepath;
        }
    }

    /**
     * create a log file if files does not exist or create a new log entry on an existing file
     * @param $message
     * @param int $type
     */
    public function create($message, $filepath, $type=0)
    {
        if (!array_key_exists($type, $this->log_types)) {
            $type = 0;
        }
        $curr_date = date('Y-m-d H:i:s');
        $log_type = $this->log_types[$type];
        $log = "[{$curr_date}] - {$log_type} - [File: {$filepath}] {$message}";
        try {
            $file = new FileHandling($this->filepath);
            $file->write($log);
        } catch (UnableToFindFilePathException $e) {
            die($e->getMessage());
        } catch (UnableToOpenFileException $e) {
            die($e->getMessage());
        }
    }


    /**
     * Takes the class path params to create the correct file path of the log file
     */
    public function resolveFilePath()
    {
        $basepath = rtrim(__PATH, PATH_SEPARATOR);
        $logpath = rtrim($this->logpath, PATH_SEPARATOR);
        $log_filename = $this->model_name.'.'.$this->file_extension;
        $filepath = $basepath.$logpath.DIRECTORY_SEPARATOR.$log_filename;
        return str_replace(['/','\\'], DIRECTORY_SEPARATOR, $filepath);
    }

    /**
     * @return string
     */
    public function getModelName()
    {
        return $this->model_name;
    }

    /**
     * @return string
     */
    public function getFilepath()
    {
        return $this->filepath;
    }

    /**
     * @return string
     */
    public function getFileExtension()
    {
        return $this->file_extension;
    }

    /**
     * @return string
     */
    public function getBasepath()
    {
        return $this->basepath;
    }

    /**
     * @return string
     */
    public function getLogpath()
    {
        return $this->logpath;
    }
}