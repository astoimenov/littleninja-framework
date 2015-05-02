<?php namespace LittleNinja\Lib;

class Database
{
    private static $db = null;

    private function __construct()
    {
        $db = new \mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        self::$db = $db;
    }

    public static function getInstance()
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new static();
        }

        return $instance;
    }

    public static function getDb()
    {
        return self::$db;
    }
}
