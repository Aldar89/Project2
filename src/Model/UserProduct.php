<?php

namespace Aldar\Project2\Model;
use Core\Model;

class UserProduct extends Model
{
    private int $id;
    private User $user;
    private Product $product;
    private int $amount;



    public static function getAllByUserId(int $user_id): array
    {
        $stmt = self::getPdo()->prepare("SELECT *
            FROM user_products
                INNER JOIN products ON products.id = user_products.product_id
                INNER JOIN users ON users.id = user_products.user_id
            WHERE user_id = :user_id
            ");
        $stmt->execute(['user_id' => $user_id]);
        $data = $stmt->fetchAll();

        $userProducts = [];
        foreach ($data as $item) {
            $userProducts[] = self::hydrateWithJoin($item);
            }
        return $userProducts;
    }

    public static function getAllByUserIdWhitoutJoin(int $user_id): array
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $data = $stmt->fetchAll();
        $userProducts = [];
        foreach ($data as $item) {
            $userProducts[] = self::hydrate($item);
        }
        return $userProducts;
    }

    public static function getByUserIdAndByProductId(int $user_id,int $product_id): ?UserProduct
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
        $data = $stmt->fetch();
        if ($data === false){
            return null;
        }
        return self::hydrate($data);
    }

    public static function create(int $user_id,int $product_id,int $amount)
    {
        $stmt = self::getPdo()->prepare("INSERT INTO user_products ( user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);
    }

    public static function addProduct(int $user_id,int $product_id,int $amount)
    {
        $stmt = self::getPdo()->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);
    }


    public static function deleteAllInCart($user_id)
    {
        $stmt = self::getPdo()->prepare("DELETE FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);

    }

    public static function removeProduct(int $user_id,int $product_id)
    {
        $stmt = self::getPdo()->prepare("DELETE FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
    }

    private static function hydrate(array $data)
    {
        $obj = new self();
        $obj->id = $data['id'];


        $userFromDB = User::getById($data['user_id']);
        $obj->user = $userFromDB;

        $productFromDB = Product::getProductById($data['product_id']);
        $obj->product = $productFromDB;
        $obj->amount = $data['amount'];
        return $obj;
    }

    private static function hydrateWithJoin($data)
    {
        $user = new User();
        $user->setId($data['user_id']);
        $user->setName($data['name']);
        $user->setEmail($data['email']);

        $product = new Product();
        $product->setId($data['product_id']);
        $product->setName($data['name']);
        $product->setPrice($data['price']);
        $product->setImage($data['image']);
        $product->setDescription($data['description']);

        $obj = new self();
        $obj->id = $data['id'];
        $obj->user = $user;
        $obj->product = $product;
        $obj->amount = $data['amount'];

        return $obj;

    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
    public function getAmount(): int
    {
        return $this->amount;

    }





    


}