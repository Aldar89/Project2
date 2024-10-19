<?php
namespace Model;

class OrderProduct extends Model
{
     public  function createOrder(int $orderId, int $productId, int $amount)
    {
        $stmt = $this->pdo->prepare("INSERT INTO order_products (order_id, product_id, amount) VALUES (:order_id, :product_id, :amount)");
        $stmt->execute(['order_id' => $orderId, 'product_id' => $productId, 'amount' => $amount]);
    }
}