<?php


require_once './../Model/UserProduct.php';

class  CartController
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
        $userProduct = new UserProduct();
        $result = $userProduct->getByUserIdAndByProductId($user_id, $product_id);
        if ($result) {
            $amount =$amount + $result['amount'];
           $userProduct->addProduct($user_id, $product_id, $amount);
        } else {
           $userProduct->create($user_id, $product_id, $amount);
        }

    }

    public function getAll()
    {
        session_start();
        $user_id = $_SESSION['user_id'];
        if (!isset($user_id)) {
            header('Location: get_login.php');
        }

        $cartModel = new UserProduct();
        $userProduct = $cartModel->getAll($user_id);

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

        require_once './../View/cart.php';
    }

}