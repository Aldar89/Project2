<?php
require_once './../Core/Autoloader.php';

use Controller\FavoriteController;
use Core\App;
use Core\Autoloader;
use Controller\UserController;
use Controller\CartController;
use Controller\ProductController;
use Controller\OrderController;

$path = __DIR__;
$path = dirname($path);
Autoloader::registrate($path);

$app = new App();
$app->addRoute('/login','GET', UserController::class, 'getLogin');
$app->addRoute('/login','POST', UserController::class, 'login');
$app->addRoute('/registrate','GET', UserController::class, 'getRegistrate');
$app->addRoute('/registrate','POST', UserController::class, 'registrate');
$app->addRoute('/catalog','GET', ProductController::class, 'getAll');
$app->addRoute('/add-product', 'GET', CartController::class, 'getAddProduct');
$app->addRoute('/add-product', 'POST', CartController::class, 'addProduct');
$app->addRoute('/remove-product', 'POST', CartController::class, 'removeProduct');
$app->addRoute('/cart','GET', CartController::class, 'getAll');
$app->addRoute('/logout','GET', UserController::class, 'logout');
$app->addRoute('/registrateOrder','GET', OrderController::class, 'getRegistrateOrder');
$app->addRoute('/registrateOrder','POST', OrderController::class, 'registrateOrder');
$app->addRoute('/add-favorite','POST', FavoriteController::class, 'addFavorite');
$app->addRoute('/favorite','GET', FavoriteController::class, 'getFavorite');
$app->addRoute('/remove-favorite','POST', FavoriteController::class, 'removeFavorite');

$app->run();






