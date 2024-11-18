<?php
header('Content-Type: text/html; charset=UTF-8');

class Database
{
    private $pdo;

    public function __construct()
    {
        $dsn = 'pgsql:host=localhost;dbname=talents;';
        $user = 'postgres';
        $password = 'sql';

        try {
            $this->pdo = new PDO($dsn, $user, $password);
            $this->pdo->exec("SET NAMES 'UTF8'");
        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }

}
