<?php

namespace Core;
use Controller\UserController;
use Controller\CartController;
use Controller\ProductController;
use Controller\OrderController;
use \Request\Request;

class App
{
    private array $routes = [];

    public function run()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        if (isset($this->routes[$requestUri])) {
            $route = $this->routes[$requestUri];

            if (isset($this->route[$requestMethod])) {
                $controllerClassName =  $this->route[$requestMethod]['class'];
                $method =$this->route[$requestMethod]['method'];
                $requestClass = $this[$method]['request'];
                $class = new $controllerClassName();
                $request= new $requestClass($requestUri,$requestMethod, $_POST);

                return $class->$method($request);


            }
            else {
                echo "Метод $requestMethod не поддерживается для адреса $requestUri";
            }

        }else {
            http_response_code(404);
            require_once "./../View/404.php";
        }

    }

    public function addRoute(string $requestUri,
                             string $requestMethod,
                             string $class,
                             string $method,
                             $requestClass = null):void
    {
        $this->routes[$requestUri][$requestMethod] = [
            'class' => $class,
            'method' => $method,
            'request' => $requestClass];


    }



}