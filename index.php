<?php
/*
 * This file is part of the Loop-Framework package.
 *
 * (c) Luis Alberto <albertoluis0108@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

include __DIR__ . "/vendor/autoload.php";

use LoopFM\Core\Registry;
use LoopFM\Core\Router;
use LoopFM\Core\Template;
use LoopFM\Lib\Configs;

header("Content-Type: text/html;charset=utf-8");


error_reporting(E_ALL);

define ('__PATH', realpath(dirname(__FILE__)));

session_start();

try {
    $registry = new Registry();
    $registry->configs = Configs::parseConfigFile(__DIR__."/src/configs/config.ini.php");
    date_default_timezone_set($registry->configs['database']['timezone']);
    $registry->router = new Router($registry);
    $registry->router->setPath(__DIR__."/src/Controllers");
    $registry->template = new Template($registry);
    $registry->router->loader();
} catch (Exception $e) {
    die($e->getMessage());
}

