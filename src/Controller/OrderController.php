<?php



require_once './../Model/UserProduct.php';
require_once './../Model/Order.php';
require_once './../Model/Product.php';
require_once './../Model/OrderProduct.php';

class OrderController

{
    public function getRegistrateOrder()
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
        }else { header("location: ../View/login.php"); }
        $cartModel = new UserProduct();
        $userProduct = $cartModel->getAll($user_id);
        require_once './../View/get_registrationOrder.php';
    }

    public function registrateOrder()
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
        }else { header("location: ../View/login.php"); }
        $errors = $this->validate();
        if (empty($errors))
        {
            $date = new DateTime();
            $date = $date->format('Y-m-d H:i:s');
            $order = new Order();
            $orderId = $order->create($user_id, $date, $_POST['first_name'], $_POST['last_name'], $_POST['address'], $_POST['phone']);

            $userProduct = new UserProduct();
            $userProducts = $userProduct->getAll($user_id);


            foreach ($userProducts as $userProduct) {
                $orderProduct = new OrderProduct();
                $productId = $userProduct['product_id'];
                $amount = $userProduct['amount'];
                $orderProduct->createOrder($orderId, $productId, $amount);
            }
        }

    }
    public function validate()
    {
        if (isset($_POST['first_name'])) {
            $first_name = $_POST['first_name'];
        }
        if (isset($_POST['last_name'])) {
            $last_name = $_POST['last_name'];
        }
        if (isset($_POST['address'])) {
            $address = $_POST['address'];
        }
        if (isset($_POST['phone'])) {
            $phone = $_POST['phone'];
        }

        $errors = [];
        if (empty($first_name)) {
            $errors['first_name'] = 'Имя не должно быть пустым!';
        } elseif (strtoupper($first_name[0] !==$first_name[0])){
            $errors['first_name'] = ' должно начинать с большой буквы';
        }
        if (strlen($first_name) < 2){
            $errors['first_name'] = ' не должно быть меньше двух символов';
        }
        if (empty($last_name)) {
            $errors['last_name'] = ' не должно быть пустым!';
        } elseif (strtoupper($last_name[0] !==$last_name[0])){
            $errors['last_name'] = ' должно начинать с большой буквы';
        }
        if (empty($address)) {
            $errors['address'] = ' не должно быть пустым!';
        } elseif(strlen($address) < 2) {
            $errors['address'] = ' не должно быть меньше двух символов';
        }
        if (empty($phone)) {
            $errors['phone'] = ' не должно быть пустым!';
        }
        elseif(strlen($phone) < 2) {
            $errors['phone'] = ' не должно быть меньше двух символов';
        }
        return $errors;
    }

}