<?php

namespace Controller;
use DTO\CreateOrderDTO;
use Model\Order;
use Model\UserProduct;
use Model\OrderProduct;
use Controller\CartController;
use Request\OrderRequest;
use Service\CartService;
use Service\OrderService;
use Service\AuthenticationSession;
use test\Cart;


class OrderController


{
    private Order $orderModel;
    private UserProduct $userProductModel;
    private CartController $cartModel;
    private OrderProduct $orderProductModel;
    private AuthenticationSession $authenticationSession;
    private OrderService $orderService;
    private CartService $cartService;
    private CreateOrderDTO $orderDTO;

    public function __construct(AuthenticationSession $authenticationSession)
    {
        $this->authenticationSession = $authenticationSession;
        $this->cartService = new CartService();
        $this->orderService = new OrderService();
//        $this->cartModel = new CartController();
    }

        public function getRegistrateOrder()
    {
        if (!$this->authenticationSession->check()) {
            header('Location: /login');
        }
        $userId = $this->authenticationSession->getUser()->getId();

        $userProducts = UserProduct::getAllByUserId($userId);

        $totalPrice = $this->cartService->getTotalPrice($userId);


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

            $dto = new CreateOrderDTO($firstName, $lastName, $address, $phone, $date, $userId);
            $this->orderService->create($dto);

            $this->cartService->deleteCart($userId);
                header("location: /catalog");

        }

    }

}