<?php

namespace Application\Core;

use Application\Config;
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
                $dsn = 'mysql:host=' . Config\DatabaseConfig::DB_HOST . ';dbname=' . Config\DatabaseConfig::DB_NAME . ';charset=utf8';
                $db = new PDO($dsn, Config\DatabaseConfig::DB_USER, Config\DatabaseConfig::DB_PASSWORD);

                // Throw an Exception when an error occurs
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOException $exception)
            {


                echo LOGS_FOLDER;
                //if(!file_exists().'/logs'))
                //die;
            }
        }

        return $db;
    }
}