<?php

namespace test;
class User
{
    public function registrate()
    {
        if (isset($_POST['name'])) {
            $name = $_POST['name'];
        }
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
        }
        if (isset($_POST['psw'])) {
            $password = $_POST['psw'];
        }
        if (isset($_POST['rep-psw'])) {
            $passwordRep = $_POST['rep-psw'];
        }
        $errors = $this->validate();

        if (empty($errors)) {

            $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hash]);

            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);

            header('Location: /login');
        }
        require_once './get_registration.php';

    }

    public function login()
    {
        $errors = [];
        if (isset($_POST['login'])) {
            $login = $_POST['login'];
        } else {
            $errors['login'] = 'Логин не должно быть пустым!';
        }
        if (isset($_POST['password'])) {
            $password = $_POST['password'];
        } else {
            $errors['password'] = 'Пароль не должно быть пустым!';
        }

        if (empty($errors)) {
            $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :login");
            $stmt->execute(['login' => $login]);
            $data = $stmt->fetch();

            if ($data === false) {
                $errors['login'] = 'Пользователя не существует';
            } elseif (password_verify($password, $data['password'])) {
//         setcookie('user_id', $data['id'], time() + 3600);
                session_start();
                $_SESSION['user_id'] = $data['id'];
                header('Location: /catalog');
            } else {
                $errors['password'] = 'Пароль указан неправильно';
            }
        }
        require_once './get_login.php';

    }

    public function validate()
    {
        if (isset($_POST['name'])) {
            $name = $_POST['name'];
        }
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
        }
        if (isset($_POST['psw'])) {
            $password = $_POST['psw'];
        }
        if (isset($_POST['rep-psw'])) {
            $passwordRep = $_POST['rep-psw'];
        }
        $errors = [];
        if (empty($name)) {
            $errors['name'] = 'Имя не должно быть пустым!';
        } elseif (strtoupper($name[0] !== $name[0])) {
            $errors['name'] = ' должно начинать с большой буквы';
        }
        if (strlen($name) < 2) {
            $errors['name'] = ' не должно быть меньше двух символов';
        }
        if (empty($email)) {
            $errors['email'] = ' не должно быть пустым!';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = ' введен некорректно';
        } else {
            $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['login' => $email]);
            $result = $stmt->fetch();
            if (!empty($result)) {
                $errors['email'] = 'email  уже занят';
            }

        }
        if (empty($password)) {
            $errors['password'] = ' не должно быть пустым!';
        } elseif (preg_match("/^[a-zA-Z0-9]+$/", $password)) {
            $errors['password'] = ' должен состоять из букв, цифр и специальных символов';
        }

        if ($password !== $passwordRep) {
            $errors['rep-psw'] = 'пароли не совпадают';
        }
        return $errors;
    }

}