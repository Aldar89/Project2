<?php
require_once './PDO.php';

class OrderProduct
{
    public  function createOrder(int $orderId, int $productId, int $amount)
    {
        $pdo = new PDO;
        $stmt = $pdo->getPdo()->prepare("INSERT INTO order_products (order_id, product_id, $amount) VALUES (:order_id, :product_id, :amount)");
        $stmt->execute(['order_id' => $orderId, 'product_id' => $productId, 'amount' => $amount]);
    }
}