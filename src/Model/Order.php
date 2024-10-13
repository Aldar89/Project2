<?php



class Order
{
    public function addInOrder(int $userId,string $firstName,string $lastName,string $address,string $phone, $date)
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, first_name, last_name, address,phone,date) VALUES (:user_id, :first_name, :last_name, :address, :phone,  :date)");
        $stmt->execute(array('user_id'=> $userId, 'first_name'=>$firstName, 'last_name'=> $lastName, 'address'=> $address, 'phone'=>$phone,'date'=>$date ));
    }

    public function getOrderId(int $userId)
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');
        $stmt = $pdo->prepare("SELECT id FROM orders WHERE user_id = :user_id ORDER BY id DESC LIMIT 1");
        $stmt->execute(array('user_id'=> $userId));
        $result = $stmt->fetch();
        return $result;
    }
}