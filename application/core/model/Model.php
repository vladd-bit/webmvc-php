<?php

namespace Application\Core;

use Application\Config\DatabaseConfig;
use PDO;
use PDOException;

abstract class Model
{
    /**
     * Get the PDO database connection
     *
     * @return mixed
     */
    protected static function getDB()
    {
        static $db = null;

        if ($db === null)
        {
            try
            {
                $dsn = DatabaseConfig::DB_ENGINE . ':host=' . DatabaseConfig::DB_HOST . ';dbname=' . DatabaseConfig::DB_NAME . ';charset=utf8';
                $db = new PDO($dsn, DatabaseConfig::DB_USER, DatabaseConfig::DB_PASSWORD);

                if(DatabaseConfig::DB_ENGINE == 'sqlite')
                {
                    $dsn = DatabaseConfig::DB_ENGINE . ":" . DatabaseConfig::DB_SQLITE_PATH;
                    $db = new PDO($dsn);
                }

                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOException $exception)
            {
                Error::log(ErrorLogType::dbError, $exception);
            }
        }

        return $db;
    }
}
