<?php
class Database
{
    private $pdo;

    public function __construct()
    {
        $dsn = 'pgsql:host=localhost;dbname=talents';
        $user = 'postgres';
        $password = 'postgres';

        try {
            $this->pdo = new PDO($dsn, $user, $password);
        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }

}
