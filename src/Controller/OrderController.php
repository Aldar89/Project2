<?php

namespace Controller;
use Model\Order;
use Model\UserProduct;
use Model\OrderProduct;
use Controller\CartController;
use Request\OrderRequest;
use Service\CartService;
use Service\OrderService;
use Service\AuthenticationSession;



class OrderController


{
    private Order $orderModel;
    private UserProduct $userProductModel;
    private CartController $cartModel;
    private OrderProduct $orderProductModel;
    private AuthenticationSession $authenticationSession;

    public function __construct(AuthenticationSession $authenticationSession)
    {
        $this->authenticationSession = $authenticationSession;
    }

        public function getRegistrateOrder()
    {
        if (!$this->authenticationSession->check()) {
            header('Location: /login');
        }
        $userId = $this->authenticationSession->getUser()->getId();

        $userProducts = UserProduct::getAllByUserId($userId);

        $totalPrice = CartService::getTotalPrice($userId);


        require_once './../View/get_registrationOrder.php';
    }

    public function registrateOrder(OrderRequest $request)
    {
        if (!$this->authenticationSession->check()) {
            header('Location: /login');
        }
        $userId = $this->authenticationSession->getUser()->getId();
        $errors = $request->validate();
        if (empty($errors))
        {
            $date = new \DateTime();
            $date = $date->format('Y-m-d H:i:s');
            $firstName = $request->getFirstName();
            $lastName = $request->getLastName();
            $address = $request->getAddress();
            $phone = $request->getPhone();


            $this->orderModel->create($userId, $firstName, $lastName, $address, $phone, $date);

            OrderService::addProductInOrder($userId);

            $this->cartModel->deleteCart();
                header("location: /catalog");

        }

    }

}