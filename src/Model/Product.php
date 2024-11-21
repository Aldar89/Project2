<?php

namespace Aldar\Project2\Model;
use Core\Model;
class Product extends Model
{
    private int $id ;
    private string $name;
    private string $image;
    private string $description;
    private float $price;


    public static function getAll():?array
    {
        $stmt = self::getPdo()->query("SELECT * FROM products ");
        $products = $stmt->fetchAll();

        foreach ($products as &$product) {
            $product = self::hydrate($product);
        }
        return $products;
    }

    public static function getProductById($id):?Product
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        if ($result === false) {
            return null;
        }
        $product = self::hydrate($result);

        return $product;
    }
    private static function hydrate(array $data): self
    {
        $obj = new self();
        $obj->id = $data['id'];
        $obj->name = $data['name'];
        $obj->description = $data['description'];
        $obj->price = $data['price'];
        $obj->image = $data['image'];

        return $obj;
    }

    public function setId(int $id): Product
    {
        $this->id = $id;
        return $this;
    }

    public function setName(string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    public function setImage(string $image): Product
    {
        $this->image = $image;
        return $this;
    }

    public function setDescription(string $description): Product
    {
        $this->description = $description;
        return $this;
    }

    public function setPrice(float $price): Product
    {
        $this->price = $price;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getImage(): string
    {
        return $this->image;
    }









}