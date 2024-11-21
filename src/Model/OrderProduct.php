<?php

namespace Aldar\Project2\Model;
use Core\Model;

class OrderProduct extends Model
{
    private int $productId;
    private int $orderId;
    private int $amount;
    private int $id;

    public static function createOrder(int $orderId, Product $product, int $amount)
    {

        $stmt = self::getPdo()->prepare("INSERT INTO order_products (order_id, product_id, amount) VALUES (:order_id, :product_id, :amount)");
        $stmt->execute(['order_id' => $orderId, 'product_id' => $product->getId(), 'amount' => $amount]);
    }

    public static function getOrderProduct(int $orderId, int $productId): ?OrderProduct
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM order_products WHERE order_id = :order_id AND product_id = :product_id");
        $stmt->execute(['order_id' => $orderId, 'product_id' => $productId]);
        $data = $stmt->fetch();
        if ($data === false) {
            return null;
        }
        return $orderProduct = self::hydrate($data);
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

    private static function hydrate($data)
    {
        $object = new self();
        $object->productId = $data['product_id'];
        $object->orderId = $data['order_id'];
        $object->amount = $data['amount'];
        $object->id = $data['id'];
        return $object;
    }
}