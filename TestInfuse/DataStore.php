<?php

namespace TestInfuse;

class DataStore
{
    protected static $db;

    public static function getDb()
    {
        if (! self::$db) {
            self::$db = new \PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
        }

        return self::$db;
    }
}