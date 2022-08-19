<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static $db;

    public function __construct()
    {
        if (self::$db === null) {
            try {
                self::$db = new PDO(
                    'mysql:host=' . Config::DB_HOST . 
                    ';dbname=' . Config::DB_NAME,
                    Config::DB_USER,
                    Config::DB_PASS,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false
                    ]
                );
            }
            catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
        }
        return self::$db;
    }

    public static function query(string $stmt)
    {
        return self::$db->query($stmt);
    }

    public static function prepare(string $stmt)
    {
        return self::$db->prepare($stmt);
    }

    public static function run(string $query, array $args = [])
    {
        try {
            if (!$args) {
                return self::query($query);
            }
            $stmt = self::prepare($query);
            $stmt->execute($args);
            return $stmt;
        }
        catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public static function getRows(string $query, array $args = [])
    {
        return self::run($query,$args)->fetchAll();
    }

    public static function getRow(string $query, array $args = [])
    {
        return self::run($query,$args)->fetch();
    }

    public static function lastInsertId() : int
    {
        return self::$db->lastInsertId();
    }
}