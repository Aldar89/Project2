<?php

namespace Model;

class Order extends Model
{

    public function create(int $userId,string $firstName,string $lastName,string $address,string $phone, $date)
    {
        $stmt = $this->pdo->prepare("INSERT INTO orders (user_id, first_name, last_name, address,phone,date) VALUES (:user_id, :first_name, :last_name, :address, :phone,  :date) RETURNING id");
        $stmt->execute(array('user_id'=> $userId, 'first_name'=>$firstName, 'last_name'=> $lastName, 'address'=> $address, 'phone'=>$phone,'date'=>$date ));

       $orderId = $stmt->fetch();
    }

    public function getOrderId(int $userId)
    {

        $stmt = $this->pdo->prepare("SELECT id FROM orders WHERE user_id = :user_id ORDER BY id DESC LIMIT 1");
        $stmt->execute(array('user_id'=> $userId));
        $result = $stmt->fetch();
        return $result;
    }
}