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
            $dsn = 'mysql:host=' . Config\WebConfig::DB_HOST . ';dbname=' . Config\WebConfig::DB_NAME . ';charset=utf8';
            $db = new PDO($dsn, Config\WebConfig::DB_USER, Config\WebConfig::DB_PASSWORD);

            // Throw an Exception when an error occurs
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $db;
    }
}