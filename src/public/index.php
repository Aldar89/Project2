<?php
use Core\App;
use Core\Autoloader;
use Controller\UserController;
use Controller\CartController;
use Controller\ProductController;
use Controller\OrderController;

require_once './../Core/Autoloader.php';

$Autoloader = new Autoloader;
$Autoloader->registrate();



$app = new App();

$app->addRoute('/login','GET', UserController::class, 'getLogin');
$app->addRoute('/login','POST', UserController::class, 'login');
$app->addRoute('/registrate','GET', UserController::class, 'getRegistrate');
$app->addRoute('/registrate','POST', UserController::class, 'registrate');
$app->addRoute('/catalog','GET', ProductController::class, 'getAll');
$app->addRoute('/add-product', 'GET', CartController::class, 'getAddProduct');
$app->addRoute('/add-product', 'POST', CartController::class, 'addProduct');
$app->addRoute('/cart','GET', CartController::class, 'getAll');
$app->addRoute('/logout','GET', UserController::class, 'logout');
$app->addRoute('/registrationOrder','GET', OrderController::class, 'getRegistrateOrder');
$app->addRoute('/registrateOrder','POST', OrderController::class, 'registrateOrder');

$app->run();






