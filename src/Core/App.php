<?php

namespace Core;
use Controller\UserController;
use Controller\CartController;
use Controller\ProductController;
use Controller\OrderController;
class App
{
    private array $routes = [];

    public function run()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        if (isset($this->routes[$requestUri])) {
            if (isset($this->routes[$requestUri][$requestMethod])) {
                $hendler =  $this->routes[$requestUri][$requestMethod];
                $class =$hendler['class'];
                $method =$hendler['method'];

                $route = new $class();
                $route->$method();

            }
            else {
                echo "Метод $requestMethod не поддерживается для адреса $requestUri";
            }

        }else {
            http_response_code(404);
            require_once "./../View/404.php";
        }

    }

    public function addRoute(string $requestUri,string $requestMethod, string $class, string $method):void
    {
        $this->routes[$requestUri][$requestMethod] = [
            'class' => $class,
            'method' => $method];

    }



}