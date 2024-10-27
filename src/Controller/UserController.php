<?php

namespace Controller;
use http\Env\Request;
use Model\User;
use Request\LoginRequest;
use Request\RegistrateRequest;

class UserController
{
     private User $user;

     public function __construct()
     {
         $this->user = new User;
     }

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


            $this->user->create($name,$email,$password);

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

            $data = $this->user->getLogin($request->getLogin());

            if ($data === null){
                $errors['login'] = 'Пользователя не существует';
            } elseif     (password_verify($request->getPassword(),$data->getPassword())){
//         setcookie('user_id', $data['id'], time() + 3600);
                session_start();
                $_SESSION['user_id'] = $data->getId();
                $user_id = $_SESSION['user_id'];
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