<?php

namespace Model;
use PDO;

class Model
{
    private static PDO $pdo;

    public  static function getPdo(): PDO
    {
       self::$pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pwd');
       return self::$pdo;
    }


}