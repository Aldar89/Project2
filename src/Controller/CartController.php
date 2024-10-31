<?php
namespace Controller;
use Model\User;
use Model\UserProduct;
use Request\ProductRequest;
use Service\CartService;
use Service\AuthenticationSession;

//require_once './../Model/UserProduct.php';

class  CartController
{
    private UserProduct $userProduct;
    private AuthenticationSession $authenticationSession;

    private CartService $cartService;

    public function __construct( AuthenticationSession $authenticationSession)
    {
        $this->authenticationSession = $authenticationSession;
        $this->cartService = new CartService();
    }

    public function getAddProduct()
    {
        require_once './../View/get_add-product.php';
    }
    public function addProduct(ProductRequest $request)
    {
        if (!$this->authenticationSession->check()) {
            header('Location: /login');
        }
        $userId = $this->authenticationSession->getUser()->getId();

        $productId = $request->getProductId();
        $amount = $request->getAmount();

        $this->cartService->getProductInaCart($userId, $productId, $amount);

        header('location: /catalog');

    }

    public function getAll()
    {
        if (!$this->authenticationSession->check()) {
            header('Location: /login');
        }
        $userId = $this->authenticationSession->getUser()->getId();

        $cartService = new CartService();
        $userProducts = UserProduct::getAllByUserIdWhitoutJoin($userId);
        $allAmount = $cartService->getAllAmount($userId);
        $totalPrice = $cartService->getTotalPrice($userId);

        require_once './../View/cart.php';
    }



//    public  function getAllCount()
//    {
//        if(session_status() === PHP_SESSION_NONE) session_start();
//        $userId = $_SESSION['user_id'];
//        if (!isset($user_id)) {
//            header('Location: /login');
//        }
//
//        CartService::getAllAmount($userId);
//    }

//    public function getTotalPrice()
//    {
//        if(session_status() === PHP_SESSION_NONE) session_start();
//        $userId = $_SESSION['user_id'];
//        if (!isset($user_id)) {
//            header('Location: /login');
//        }
//
//       CartService::getTotalPrice($userId);
//    }

    public function deleteCart()
    {
        if (!$this->authenticationSession->check()) {
        header('Location: /login');
    }
        $userId = $this->authenticationSession->getUser()->getId();

        UserProduct::deleteAllInCart($userId);
    }

    public function removeProduct(ProductRequest $request)
    {
        if (!$this->authenticationSession->check()) {
            header('Location: /login');
        }
        $userId = $this->authenticationSession->getUser()->getId();
        $productId = $request->getProductId();


        UserProduct::removeProduct($userId, $productId);
        header('location: /cart');
    }



}