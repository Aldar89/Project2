<?php

namespace test;
class Product
{
    public function getAll()
    {
        session_start();
//$user_id = $_COOKIE['user_id'];
        $user_id = $_SESSION['user_id'];
        if (!isset($user_id)) {
            header('Location: get_login.php');
        }
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');
        $stmt = $pdo->query("SELECT * FROM products ");
        $products = $stmt->fetchAll();
        require_once './../View/catalog.php';
    }

}