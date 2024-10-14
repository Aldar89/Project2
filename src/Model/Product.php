<?php

require_once './PDO.php';
class Product
{
    public function getAll()
    {
        $pdo = new PDO;
        $stmt = $pdo->getPdo()->query("SELECT * FROM products ");
        $products = $stmt->fetchAll();
        return $products;
    }

    public static function getProductId(int $productId)
    {
        $pdo = new PDO;
        $stmt = $pdo->getPdo()->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $productId]);
        $result = $stmt->fetch();
        return $result;
    }
}