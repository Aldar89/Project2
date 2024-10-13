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

    public static function getProductId(int $productId)
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $productId]);
        $result = $stmt->fetch();
        return $result;
    }
}