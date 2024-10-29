<?php

namespace Service;

use Model\UserProduct;

class CartService
{
    public static function getProductInaCart($userId, $productId, $amount)
    {
        $result = UserProduct::getByUserIdAndByProductId($userId, $productId);

        if ($result) {
            $amount = $amount + $result['amount'];
            UserProduct::addProduct($userId, $productId, $amount);

        } else {
            UserProduct::create($userId, $productId, $amount);
        }
    }

    public static function getAllAmount($userId):int
    {
        $userProducts = UserProduct::getAllByUserIdWhitoutJoin($userId);
        $allAmount = 0;

        foreach ($userProducts as $product) {
            $amount = $product->getAmount();
            $allAmount +=$amount;
        }
        return $allAmount;
    }
    public static function getTotalPrice($userId):float
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
}