<?php

class Product
{
    public function getAll()
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');
        $stmt = $pdo->query("SELECT * FROM products ");
        $products = $stmt->fetchAll();
        return $products;
    }
}