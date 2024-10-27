<?php

namespace Request;

class RegistrateRequest extends Request
{
     public function getNameUser():?string
     {
         return $this->data['name'] ?? null;
     }

     public function getEmail():?string
     {
         return $this->data['email'] ?? null;
     }

     public function getPassword():?string
     {
         return $this->data['password'] ?? null;
     }

    public function validate()
    {
        if (isset($this->data['name'])) {
            $name = $this->data['name'];
        }
        if (isset($this->data['email'])) {
            $email = $this->data['email'];
        }
        if (isset($this->data['psw'])) {
            $password = $this->data['psw'];
        }
        if (isset($this->data['rep-psw'])) {
            $passwordRep = $this->data['rep-psw'];
        }

        $errors = [];
        if (empty($name)) {
            $errors['name'] = 'Имя не должно быть пустым!';
        } elseif (strtoupper($name[0] !==$name[0])){
            $errors['name'] = ' должно начинать с большой буквы';
        }
        if (strlen($name) < 2){
            $errors['name'] = ' не должно быть меньше двух символов';
        }
        if (empty($email)) {
            $errors['email'] = ' не должно быть пустым!';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = ' введен некорректно';
        }
        if (empty($password)) {
            $errors['password'] = ' не должно быть пустым!';
        } elseif(preg_match("/^[a-zA-Z0-9]+$/", $password)){
            $errors['password'] = ' должен состоять из букв, цифр и специальных символов';
        }

        if ($password !== $passwordRep){
            $errors['rep-psw'] = 'пароли не совпадают';
        }
        return $errors;
    }
}