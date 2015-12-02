<?php

namespace Pengjie\Config;

use \PDO;

class DB
{
    private $host = 'localhost';
    private $username = 'Your Account';
    private $password = 'Your Password';
    private $dbName = 'Your DataBase';
    private $db;

    public function __construct()
    {
        try {
            $this->db = new PDO(
                "mysql:host=$this->host; dbname=$this->dbName; charset=utf8",
                $this->username,
                $this->password,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
        } catch (PDOException $e) {
            echo __LINE__ . ': ' . $e->getMessage();
        }
    }

    public function insertCourses($data, $config)
    {
        // ignore.
    }
}