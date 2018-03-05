<?php
/*
 * This file is part of the Loop-Framework package.
 *
 * (c) Luis Alberto <albertoluis0108@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LoopFM\Lib\Database;

use LoopFM\Lib\Http\Header;
use LoopFM\Lib\Logger\Logger;

class DB extends \PDO
{
    /**
     * Wrapper class for PDO
     * @param array $configs - Array of configs from config.ini.php
     */
    public function __construct(array $configs)
    {
        try {
            $dsn = "mysql:host={$configs['host']};dbname={$configs['dbname']};charset={$configs['charset']};";
            $username = $configs['username'];
            $passwd = $configs['passwd'];
            $opt = array (
                self::ATTR_ERRMODE            => self::ERRMODE_EXCEPTION,
                self::ATTR_DEFAULT_FETCH_MODE => self::FETCH_ASSOC,
                self::ATTR_EMULATE_PREPARES   => false,
                self::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '. $configs['charset']
            );
            parent::__construct($dsn, $username, $passwd, $opt);
        } catch (\PDOException $e) {
            $log = new Logger('DB');
            $log->create($e->getMessage(), $e->getFile(), 2);
            Header::err500();
            die('Um erro inesperado ocorreu. Tente novamente mais tarde, ou contate um administrador.');
        }
    }
}