<?php

namespace Application\Core;

use Application\Config;
use PDO;

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
            $dsn = 'mysql:host=' . Config\DatabaseConfig::DB_HOST . ';dbname=' . Config\DatabaseConfig::DB_NAME . ';charset=utf8';
            $db = new PDO($dsn, Config\DatabaseConfig::DB_USER, Config\DatabaseConfig::DB_PASSWORD);

            // Throw an Exception when an error occurs
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $db;
    }
}