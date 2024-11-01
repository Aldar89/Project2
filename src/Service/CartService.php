<?php

namespace Service;

use Model\User;
use Model\UserProduct;

class CartService
{
    public  function getProductInaCart($userId, $productId, $amount)
    {
        $result = UserProduct::getByUserIdAndByProductId($userId, $productId);

        if ($result) {
            $amount = $amount + $result->getAmount();
            UserProduct::addProduct($userId, $productId, $amount);

        } else {
            UserProduct::create($userId, $productId, $amount);
        }
    }

    public  function getAllAmount($userId):int
    {
        $userProducts = UserProduct::getAllByUserIdWhitoutJoin($userId);
        $allAmount = 0;

        foreach ($userProducts as $product) {
            $amount = $product->getAmount();
            $allAmount +=$amount;
        }
        return $allAmount;
    }
    public function getTotalPrice($userId):float
    {
        $userProduct = UserProduct::getAllByUserIdWhitoutJoin($userId);
        $totalPrice = 0;
        foreach ($userProduct as $product) {
            $amount = $product->getAmount();
            $price  = $product->getProduct()->getPrice();
            $totalPrice +=$amount*$price;
        }
        return $totalPrice;

    }
    public function deleteCart($userId)
    {
        UserProduct::deleteAllInCart($userId);
    }
}