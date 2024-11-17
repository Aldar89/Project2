<?php

namespace Model;

use Core\Model;

class Order extends Model
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private string $address;
    private string $phone;
    private string $date;


    public static function create(int $userId,string $firstName,string $lastName,string $address,string $phone, $date)
    {
        $stmt = self::getPdo()->prepare("INSERT INTO orders (user_id, first_name, last_name, address,phone,date) VALUES (:user_id, :first_name, :last_name, :address, :phone,  :date)");
        $stmt->execute(array('user_id'=> $userId, 'first_name'=>$firstName, 'last_name'=> $lastName, 'address'=> $address, 'phone'=>$phone,'date'=>$date ));

    }

    public static function getOrderId(int $userId):?Order
    {

        $stmt = self::getPdo()->prepare("SELECT * FROM orders WHERE user_id = :user_id ORDER BY id DESC");
        $stmt->execute(array('user_id'=> $userId));
        $data = $stmt->fetch();
        if ($data === false) {
            return null;
        }
        $order = self::hydrate($data);
        return $order;
    }

    public static function getAllOrders(int $userId):array
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM orders where user_id = :user_id ");
        $stmt->execute(['user_id' => $userId]);
        $orders = $stmt->fetchAll();

        $result = [];
        foreach ($orders as $order) {
           $result[] = self::hydrate($order);

        }
        return $result;
    }



    private static function hydrate(array $data):self
    {
        $obj = new self();
        $obj->id = $data['id'];
        $obj->firstName = $data['first_name'];
        $obj->lastName = $data['last_name'];
        $obj->address = $data['address'];
        $obj->phone = $data['phone'];
        $obj->date = $data['date'];
        return $obj;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }




}