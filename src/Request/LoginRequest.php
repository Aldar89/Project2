<?php

namespace Request;

class LoginRequest extends Request
{
    public function getLogin(): ?string
    {
        return $this->data['login'] ?? null;
    }

    public function getPassword(): ?string
    {
        return $this->data['password']  ?? null;;
    }

    public function validate(): array
    {
        $errors = [];
        if (isset($this->data['login'])) {
            $login = $this->data['login'];
        } else {
            $errors['login'] = 'Логин не должно быть пустым!';
        }
        if (isset($this->data['password'])) {
            $password = $this->data['password'];
        } else {
            $errors['password'] = 'Пароль не должно быть пустым!';
        }
        return $errors;
    }
}