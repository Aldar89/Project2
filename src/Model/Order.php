<?php

namespace Model;

class Order extends Model
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private string $address;
    private string $phone;
    private string $date;


    public function create(int $userId,string $firstName,string $lastName,string $address,string $phone, $date)
    {
        $stmt = $this->pdo->prepare("INSERT INTO orders (user_id, first_name, last_name, address,phone,date) VALUES (:user_id, :first_name, :last_name, :address, :phone,  :date)");
        $stmt->execute(array('user_id'=> $userId, 'first_name'=>$firstName, 'last_name'=> $lastName, 'address'=> $address, 'phone'=>$phone,'date'=>$date ));

    }

    public function getOrderId(int $userId):?Order
    {

        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE user_id = :user_id ORDER BY id DESC");
        $stmt->execute(array('user_id'=> $userId));
        $data = $stmt->fetch();
        if ($data === false) {
            return null;
        }
        $order = $this->hydrate($data);
        return $order;
    }

    private function hydrate(array $data):self
    {
        $this->id = $data['id'];
        $this->firstName = $data['first_name'];
        $this->lastName = $data['last_name'];
        $this->address = $data['address'];
        $this->phone = $data['phone'];
        $this->date = $data['date'];
        return $this;
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