<?php
namespace Model;

class OrderProduct extends Model
{
    private int $productId;
    private int $orderId;
    private int $amount;
    private int $id;

     public  function createOrder(int $orderId,Product $product, int $amount)
    {
        $stmt = $this->pdo->prepare("INSERT INTO order_products (order_id, product_id, amount) VALUES (:order_id, :product_id, :amount)");
        $stmt->execute(['order_id' => $orderId, 'product_id' => $product->getId(), 'amount' => $amount]);
    }

    public function getProductId(): Product
    {
        return $this->productId;
    }

    public function getOrderId(): Order
    {
        return $this->orderId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getId(): int
    {
        return $this->id;
    }


}