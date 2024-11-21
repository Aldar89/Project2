<?php

namespace Aldar\Project2\Controller;
use Aldar\Project2\DTO\CreateOrderDTO;
use Aldar\Project2\Model\Order;
use Aldar\Project2\Model\OrderProduct;
use Aldar\Project2\Model\UserProduct;
use Aldar\Project2\Request\OrderRequest;
use Aldar\Project2\Service\Authentication\AuthenticationSession;
use Core\Authentication\AuthServiceInterface;
use Aldar\Project2\Service\CartService;
use Aldar\Project2\Service\OrderService;


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