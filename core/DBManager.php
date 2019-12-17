<?php
namespace Core;

class DBManager {
    protected static $dbh;
    protected static $config;
    protected static $paginationCount;

    public static function setup($config, $paginationCount) {
        self::$config = $config;
        self::$paginationCount = $paginationCount;
    }

    public static function getPaginationCount() {
        return self::$paginationCount;
    }

    /**
     * @return \PDO
     */
    public static function getConnection() {
        if (!self::$dbh) {
            $config = self::$config;
            $dbh = new \PDO($config['dsn'], $config['username'], $config['password']);
            if ($config['encoding']) {
                $dbh->exec("set names {$config['encoding']}");
            }
            self::$dbh = $dbh;
        }
        return self::$dbh;
    }

    public static function close() {
        self::$dbh = null;
    }
}