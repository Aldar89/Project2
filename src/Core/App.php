<?php

require_once './../Controller/UserController.php';
require_once './../Controller/CartController.php';
require_once './../Controller/ProductController.php';
require_once './../Controller/OrderController.php';
class App
{
    private array $routes = [
        '/login' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getlogin',
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'login',

            ],
        ],
        '/registrate' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getRegistrate',
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'registrate',

            ],
        ],
        '/catalog2' => [
            'GET' => [
                'class' => 'ProductController',
                'method' => 'getAll',
            ],
        ],
        '/add-product' => [
            'GET' => [
                'class' => 'CartController',
                'method' => 'getAddProduct',
            ],
            'POST' => [
                'class' => 'CartController',
                'method' => 'addProduct',
            ],
        ],
        '/cart' => [
            'GET' => [
                'class' => 'CartController',
                'method' => 'getAll',
            ],
        ],
        '/logout' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'logout',
            ],
        ],
        '/registrateOrder' => [
            'GET' => [
                'class' => 'OrderController',
                'method' => 'getRegistrateOrder',
            ],
            'POST' => [
                'class' => 'OrderController',
                'method' => 'registrateOrder',
            ],
        ],

    ];
    public function run()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        $route = $this->routes[$requestUri][$requestMethod];
        $class = $route['class'];
        $method = $route['method'];
        $controller = new $class();
        $controller->$method();
    }



}