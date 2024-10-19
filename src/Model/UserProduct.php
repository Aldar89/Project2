<?php

namespace Model;
class UserProduct extends Model
{

    public function getAllByUserId(int $user_id)
    {
        $stmt = $this->pdo->prepare("SELECT products.name AS product_name,
       products.image, products.description, products.price, users.name AS user_name, user_products.amount,
         user_products.product_id AS product_id
        FROM user_products 
        JOIN users ON users.id = user_products.user_id 
        JOIN products ON products.id = user_products.product_id 
        WHERE user_products.user_id = :user_id");

        $stmt->execute(['user_id' => $user_id]);
        $userProduct = $stmt->fetchAll();
        return $userProduct;
    }

    public function getByUserIdAndByProductId(int $user_id,int $product_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
        $result = $stmt->fetch();
        return $result;
    }

    public function create(int $user_id,int $product_id,int $amount)
    {
        $stmt = $this->pdo->prepare("INSERT INTO user_products ( user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);
    }

    public function addProduct(int $user_id,int $product_id,int $amount)
    {
        $stmt = $this->pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);
    }

    public function getAmount(int $user_id,int $product_id)
    {
        $stmt = $this->pdo->prepare("SELECT amount FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
        $result = $stmt->fetch();

    }

    public function deleteAllInCart($user_id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);

    }

    


}