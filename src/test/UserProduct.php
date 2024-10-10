<?php

namespace test;
class UserProduct
{
    public function addProduct()
    {
        session_start();
        $user_id = $_SESSION['user_id'];
        if (isset($_POST['product_id'])) {
            $product_id = $_POST['product_id'];
        }

        if (isset($_POST['amount'])) {
            $amount = $_POST['amount'];
        }
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');

        $stmt = $pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
        $result = $stmt->fetch();
        if ($result) {
            $amount = $amount + $result['amount'];
            $stmt = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user_id AND product_id = :product_id");
            $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO user_products ( user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
            $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);
        }

    }
}