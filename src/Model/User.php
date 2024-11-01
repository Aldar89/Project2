<?php

namespace Model;
use Model\Model;
class User extends Model
{
    private string $id;
    private string $name;
    private string $email;
    private string $password;


    public static function create(string $password,string $name,string $email)
    {
        $stmt = self::getPdo()->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hash]);
        $stmt = self::getPdo()->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);

    header('Location: /login');
    }

    public static function getByEmail(string $email): ?User
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch();
        if ($data === false) {
            return null;
        }


        return self::hydrate($data);
    }

    public static function  getLogin(string $login):?User
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM users WHERE email = :login");
        $stmt->execute(['login' => $login]);
        $data = $stmt->fetch();

        if ($data === false) {
            return null;
        }
        return self::hydrate($data);

    }

    public static function getById(int $id)
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch();
        if ($data === false) {
            return null;
        }
        return self::hydrate($data);
    }

    public static function hydrate(array $data)
    {
        $obj = new self();
        $obj->id = $data['id'];
        $obj->name = $data['name'];
        $obj->email = $data['email'];
        $obj->password = $data['password'];

        return $obj;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setId(string $id): User
    {
        $this->id = $id;
        return $this;
    }

    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

}