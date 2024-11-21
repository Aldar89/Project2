<?php

namespace Aldar\Project2\Request;
use Core\Request;

class OrderRequest extends Request
{
    public function getFirstName():?string
    {
        return $this->data['first_name'] ?? null;;
    }

    public function getLastName():?string
    {
        return $this->data['last_name'] ?? null;
    }

    public function getaddress():?string
    {
        return $this->data['address'] ?? null;
    }

    public function getPhone():?string
    {
        return $this->data['phone'] ?? null;
    }

    public function getdate():?string
    {
        return $this->data['date']  ?? null;
    }

    public function validate()
    {
        if (isset($this->data['first_name'])) {
            $first_name = $this->data['first_name'];
        }
        if (isset($this->data['last_name'])) {
            $last_name = $this->data['last_name'];
        }
        if (isset($this->data['address'])) {
            $address = $this->data['address'];
        }
        if (isset($this->data['phone'])) {
            $phone = $this->data['phone'];
        }

        $errors = [];
        if (empty($first_name)) {
            $errors['first_name'] = 'Имя не должно быть пустым!';
        } elseif (strtoupper($first_name[0] !==$first_name[0])){
            $errors['first_name'] = ' должно начинать с большой буквы';
        }
        if (strlen($first_name) < 2){
            $errors['first_name'] = ' не должно быть меньше двух символов';
        }
        if (empty($last_name)) {
            $errors['last_name'] = ' не должно быть пустым!';
        } elseif (strtoupper($last_name[0] !==$last_name[0])){
            $errors['last_name'] = ' должно начинать с большой буквы';
        }
        if (empty($address)) {
            $errors['address'] = ' не должно быть пустым!';
        } elseif(strlen($address) < 2) {
            $errors['address'] = ' не должно быть меньше двух символов';
        }
        if (empty($phone)) {
            $errors['phone'] = ' не должно быть пустым!';
        }
        elseif(strlen($phone) < 2) {
            $errors['phone'] = ' не должно быть меньше двух символов';
        }
        return $errors;
    }

}