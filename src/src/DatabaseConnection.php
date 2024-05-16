<?php

namespace src;

use mysqli;

final class DatabaseConnection
{
    private static $instance = null;
    private static $connection;

    static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new DatabaseConnection();
        }
        return self::$instance;
    }

    static function connect($hostname, $user, $password, $dbName)
    {
        self::$connection = new mysqli($hostname, $user, $password, $dbName);
    }

    function getConnection()
    {
        return self::$connection;
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }
}
