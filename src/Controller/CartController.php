<?php


require_once './../Model/UserProduct.php';

class  CartController
{
    public function addProduct()
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
        }else { header("location: ../View/login.php"); }
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
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
        }else { header("location: ../View/login.php"); }

        $UserProductModel = new UserProduct();
        $userProduct = $UserProductModel->getAll($user_id);
        $allAmount = $this->getAllCount();

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

    public function deleteProductCart()
    {
        session_start();
        $user_id = $_SESSION['user_id'];
        if (!isset($user_id)) {
            header('Location: /login');
        }
        $cartModel = new UserProduct();
        $userProduct = $cartModel->deleteAll($user_id);

    }

    public function getAllCount()
    {
        session_start();
        $user_id = $_SESSION['user_id'];

        $UserProductModel = new UserProduct();
        $userProduct = $UserProductModel->getAll($user_id);

        foreach ($userProduct as $product) {
            $amount = $product['amount'];
            $allAmount +=$amount;
        }
        return $allAmount;

    }

}