<?php

class PDO
{
    public  function getPdo()
    {
        return $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pwd');
    }

}