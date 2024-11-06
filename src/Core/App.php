<?php

namespace Core;
use Controller\UserController;
use Controller\CartController;
use Controller\ProductController;
use Controller\OrderController;
use DateTime;
use http\Client\Request;
use Service\AuthenticationSession;
use Service\LoggerService;

class App
{
    private array $routes = [];
    private LoggerService $loggerService;

    private function __construct()
    {
        $this->loggerService = new LoggerService();
    }

    public function run()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        if (isset($this->routes[$requestUri])) {
            $route = $this->routes[$requestUri];

            if (isset($route[$requestMethod])) {
                $controllerClassName =  $route[$requestMethod]['class'];
                $method =$route[$requestMethod]['method'];
                $requestClass = $route[$requestMethod]['request'];
                $authService = new AuthenticationSession();

                $class = new $controllerClassName($authService);

                try {
                    if (empty($requestClass)){
                    return $class->$method();
                }else{
                    $request = new $requestClass($requestUri, $requestMethod, $_POST);
                    return $class->$method($request);
                }
                } catch (\Throwable $exception) {
                    $date = new DateTime();
                    $error = [
                    'message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine()
                    ];

                    $this->loggerService->error($error);

                    http_response_code(500);
                    require_once './../View/500.php';
                }
                if (empty($requestClass)){
                    return $class->$method();
                }else{
                    $request = new $requestClass($requestUri, $requestMethod, $_POST);
                    return $class->$method($request);
                }
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

    public function getRoute(string $route, string $className, string $methodName, $requestClass = null)
    {
        $this->routes[$route]['GET']= [
            'class' => $className,
            'method' => $methodName,
            'request' => $requestClass
        ];
    }
    public function postRoute(string $route, string $className, string $methodName, $requestClass = null)
    {
        $this->routes[$route]['POST']= [
            'class' => $className,
            'method' => $methodName,
            'request' => $requestClass
        ];
    }




}