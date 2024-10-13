<?php

class OrderProduct
{
    public static function create(int $orderId, int $productId, int $amount)
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');
        $stmt = $pdo->prepare("INSERT INTO order_products (order_id, product_id, $amount) VALUES (:order_id, :product_id, :amount)");
        $stmt->execute(['order_id' => $orderId, 'product_id' => $productId, 'quantity' => $amount]);
    }
}