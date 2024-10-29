<?php
namespace Controller;
use Model\Product;
use Service\AuthenticationSession;
//require_once './../Model/Product.php';
//require_once './../Controller/CartController.php';
class ProductController
{
    public function __construct(AuthenticationSession $authenticationSession)
    {
        $this->authenticationSession = $authenticationSession;
    }

    public function getAll()
    {
        if (!$this->authenticationSession->check()) {
            header('Location: /login');
        }
        $userId = $this->authenticationSession->getUser()->getId();

        $products = Product::getAll();
        $cart = new CartController();
        $allAmount = $cart->getAllCount();
        require_once './../View/catalog2.php';
    }
}