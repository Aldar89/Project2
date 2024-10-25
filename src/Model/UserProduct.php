<?php

namespace Model;
class UserProduct extends Model
{
    private int $id;
    private User $user;
    private Product $product;
    private int $amount;

    public function __construct()
    {
        parent::__construct();
        $this->user = new User();
        $this->product = new Product();
        $this->amount = 0;


    }

    public function getAllByUserId(int $user_id): array
    {
        $stmt = $this->pdo->prepare("SELECT *
            FROM user_products
                INNER JOIN products ON products.id = user_products.product_id
                INNER JOIN users ON users.id = user_products.user_id
            WHERE user_id = :user_id
            ");
        $stmt->execute(['user_id' => $user_id]);
        $data = $stmt->fetchAll();

        $userProducts = [];
        foreach ($data as $item) {
            $userProducts[] = $this->hydrateWithJoin($item);
            }
        return $userProducts;
    }

    public function getAllByUserIdWhitoutJoin(int $user_id): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $data = $stmt->fetchAll();
        $userProducts = [];
        foreach ($data as $item) {
            $userProducts[] = $this->hydrate($item);
        }
        return $userProducts;
    }

    public function getByUserIdAndByProductId(int $user_id,int $product_id): ?UserProduct
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
        $data = $stmt->fetch();
        if ($data === false){
            return null;
        }
        return $this->hydrate($data);
    }

    public function create(int $user_id,int $product_id,int $amount)
    {
        $stmt = $this->pdo->prepare("INSERT INTO user_products ( user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);
    }

    public function addProduct(int $user_id,int $product_id,int $amount)
    {
        $stmt = $this->pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);
    }


    public function deleteAllInCart($user_id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);

    }

    public function removeProduct(int $user_id,int $product_id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
    }

    private function hydrate(array $data)
    {
        $obj = new self();
        $obj->id = $data['id'];

        $user = new User();
        $userFromDB = $user->getById($data['user_id']);
        $obj->user = $userFromDB;

        $product = new Product();
        $productFromDB = $product->getProductById($data['product_id']);
        $obj->product = $productFromDB;
        $obj->amount = $data['amount'];
        return $obj;
    }

    private function hydrateWithJoin($data)
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