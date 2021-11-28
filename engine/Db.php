<?php

namespace engine;

class Db
{
    public $pdo;
    private static $instance;

    public static function instance(): Db
    {
        if (self::$instance === null)
            self::$instance = new self;
        return self::$instance;
    }

    private function __construct()
    {
        $dbCnf = require_once ROOT . '/config/db.php';
        $this->pdo = new \PDO('mysql:host=' . $dbCnf['host'] . ';dbname=' . $dbCnf['name'] . ';charset=utf8', $dbCnf['user'], $dbCnf['pass']);
        $this->pdo->exec('SET NAMES ' . $dbCnf['charset']);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function __clone() {}

}