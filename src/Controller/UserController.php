<?php

namespace Aldar\Project2\Controller;
use Aldar\Project2\Model\User;
use Aldar\Project2\Request\LoginRequest;
use Aldar\Project2\Request\RegistrateRequest;

class UserController
{
     private User $user;


    public function getRegistrate()
    {
        require_once "./../View/get_registration.php";
    }



    public function registrate(RegistrateRequest $request)
    {
        $name = $request->getNameUser();
        $email = $request->getEmail();
        $password = $request->getPassword();

        $errors=$request->validate();

        if (empty($errors)) {


           User::create($name,$email,$password);

            header('Location: /login');
        }
        require_once './get_registration.php';

    }

    public function getLogin()
    {
        require_once './../View/get_login.php';
    }

    public function login(LoginRequest $request)
    {
        $errors=$request->validate();

        if (empty($errors)) {

            $login = $request->getLogin();
            $password = $request->getPassword();
            $data = User::getLogin($login);
            $passwordFromDB = User::getLogin($login)->getPassword();

            if ($data === null){
                $errors['login'] = 'Пользователя не существует';
            } elseif     (password_verify($password,$passwordFromDB)){
//         setcookie('user_id', $data['id'], time() + 3600);
                session_start();
                $id = $data->getId();
                $_SESSION['user_id'] = $id;

                $userId = $_SESSION['user_id'];

                header('Location: /catalog');
            } else {
                $errors['password'] = 'Пароль указан неправильно';
            }
        }
        require_once './../View/get_login.php';

    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /login');
    }

}