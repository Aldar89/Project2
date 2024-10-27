<?php
require_once './../Core/Autoloader.php';

use Controller\FavoriteController;
use Core\App;
use Core\Autoloader;
use Controller\UserController;
use Controller\CartController;
use Controller\ProductController;
use Controller\OrderController;
use Request\LoginRequest;
use Request\ProductRequest;
use Request\OrderRequest;
use Request\RegistrateRequest;

$path = __DIR__;
$path = dirname($path);
Autoloader::registrate($path);

$app = new App();
$app->addRoute('/login','GET', UserController::class, 'getLogin');
$app->addRoute('/login','POST', UserController::class, 'login', LoginRequest::class );
$app->addRoute('/registrate','GET', UserController::class, 'getRegistrate');
$app->addRoute('/registrate','POST', UserController::class, 'registrate', RegistrateRequest::class );
$app->addRoute('/catalog','GET', ProductController::class, 'getAll');
$app->addRoute('/add-product', 'GET', CartController::class, 'getAddProduct');
$app->addRoute('/add-product', 'POST', CartController::class, 'addProduct', ProductRequest::class) ;
$app->addRoute('/remove-product', 'POST', CartController::class, 'removeProduct', ProductRequest::class) ;
$app->addRoute('/cart','GET', CartController::class, 'getAll');
$app->addRoute('/logout','GET', UserController::class, 'logout');
$app->addRoute('/registrateOrder','GET', OrderController::class, 'getRegistrateOrder');
$app->addRoute('/registrateOrder','POST', OrderController::class, 'registrateOrder', OrderRequest::class);
$app->addRoute('/add-favorite','POST', FavoriteController::class, 'addFavorite', ProductRequest::class );
$app->addRoute('/favorite','GET', FavoriteController::class, 'getFavorite');
$app->addRoute('/remove-favorite','POST', FavoriteController::class, 'removeFavorite', ProductRequest::class );

$app->run();






