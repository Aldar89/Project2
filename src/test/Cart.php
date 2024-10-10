<?php

namespace test;
class Cart
{
    public function getAll()
    {
        session_start();
        $user_id = $_SESSION['user_id'];
        if (!isset($user_id)) {
            header('Location: get_login.php');
        }
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');
//$stmt = $pdo->prepare("SELECT * FROM user_products where user_id = :user_id");
//$stmt->execute(['user_id' => $user_id]);
//$productIds = $stmt->fetchAll();
//print_r($productIds);
//$userProduct =[];
//foreach ($productIds as $productId) {
//    $product = $productId['product_id'];
//    $userProduct['amount'] = $productId['amount'];
//    $stmt = $pdo->prepare("SELECT * FROM products where id = :product");
//    $stmt->execute(['product' => $product]);
//    $userProduct[] = $stmt->fetch();
//    print_r($userProduct);
        $stmt = $pdo->prepare("SELECT products.name AS product_name, products.image, products.description, products.price, users.name AS user_name, user_products.amount 
        FROM user_products 
        JOIN users ON users.id = user_products.user_id 
        JOIN products ON products.id = user_products.product_id 
        WHERE user_products.user_id = :user_id");

        $stmt->execute(['user_id' => $user_id]);
        $userProduct = $stmt->fetchAll();

        require_once './../View/cart.php';
    }
}