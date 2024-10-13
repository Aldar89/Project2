<?php


class UserProduct
{
    public function getAll(int $user_id)
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');
        $stmt = $pdo->prepare("SELECT products.name AS product_name, products.image, products.description, products.price, users.name AS user_name, user_products.amount 
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
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');

        $stmt = $pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
        $result = $stmt->fetch();
        return $result;
    }

    public function create(int $user_id,int $product_id,int $amount)
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');

        $stmt = $pdo->prepare("INSERT INTO user_products ( user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);
    }

    public function addProduct(int $user_id,int $product_id,int $amount)
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');

        $stmt = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);
    }

    public function getAmount(int $user_id,int $product_id)
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');
        $stmt = $pdo->prepare("SELECT amount FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
        $result = $stmt->fetch();

    }


}