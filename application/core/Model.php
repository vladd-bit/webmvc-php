<?php

namespace Application\Core;

use Application\Config\DatabaseConfig;
use Application\Config\WebConfig;
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
                $dsn = 'mysql:host=' . DatabaseConfig::DB_HOST . ';dbname=' . DatabaseConfig::DB_NAME . ';charset=utf8';
                $db = new PDO($dsn, DatabaseConfig::DB_USER, DatabaseConfig::DB_PASSWORD);

                // Throw an Exception when an error occurs
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOException $exception)
            {
                $dbLogFilePath = LOGS_FOLDER.'/'.WebConfig::DB_ERROR_LOG_FILENAME;
                if(file_exists($dbLogFilePath))
                {
                    $file = fopen($dbLogFilePath, 'a');
                    fwrite($file, "\n".$exception);
                }
                else
                {
                    $file = fopen($dbLogFilePath, 'w');
                    fwrite($file, "\n".$exception);
                }

                die();
            }
        }

        return $db;
    }
}