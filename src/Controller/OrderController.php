<?php

namespace Controller;
use DTO\CreateOrderDTO;
use Model\Order;
use Model\OrderProduct;
use Model\UserProduct;
use Request\OrderRequest;
use Service\Authentication\AuthenticationSession;
use Service\Authentication\AuthServiceInterface;
use Service\CartService;
use Service\OrderService;


class OrderController


{
    private Order $orderModel;
    private UserProduct $userProductModel;
    private CartController $cartModel;
    private OrderProduct $orderProductModel;
    private AuthServiceInterface $authService;
    private OrderService $orderService;
    private CartService $cartService;
    private CreateOrderDTO $orderDTO;

    public function __construct(AuthServiceInterface $authService, CartService $cartService, OrderService $orderService)
    {
        $this->authService = $authService;
        $this->cartService = $cartService;
        $this->orderService = $orderService;
//        $this->cartModel = new CartController();
    }

        public function getRegistrateOrder()
    {
        if (!$this->authService->check()) {
            header('Location: /login');
        }
        $userId = $this->authService->getUser()->getId();

        $userProducts = UserProduct::getAllByUserId($userId);

        $totalPrice = $this->cartService->getTotalPrice($userId);


        require_once './../View/get_registrationOrder.php';
    }

    public function registrateOrder(OrderRequest $request)
    {
        if (!$this->authService->check()) {
            header('Location: /login');
        }
        $userId = $this->authService->getUser()->getId();
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
            $this->orderService->create($dto, $userId);


                header("location: /catalog");

        }

    }

}