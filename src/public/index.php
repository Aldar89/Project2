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
$app->getRoute('/login', UserController::class, 'getLogin');
$app->postRoute('/login', UserController::class, 'login', LoginRequest::class );
$app->getRoute('/registrate', UserController::class, 'getRegistrate');
$app->postRoute('/registrate', UserController::class, 'registrate', RegistrateRequest::class );
$app->getRoute('/catalog', ProductController::class, 'getAll');
$app->getRoute('/add-product',  CartController::class, 'getAddProduct');
$app->postRoute('/add-product',  CartController::class, 'addProduct', ProductRequest::class) ;
$app->postRoute('/remove-product',  CartController::class, 'removeProduct', ProductRequest::class) ;
$app->getRoute('/cart',CartController::class, 'getAll');
$app->getRoute('/logout', UserController::class, 'logout');
$app->getRoute('/registrateOrder', OrderController::class, 'getRegistrateOrder');
$app->postRoute('/registrateOrder', OrderController::class, 'registrateOrder', OrderRequest::class);
$app->postRoute('/add-favorite', FavoriteController::class, 'addFavorite', ProductRequest::class );
$app->getRoute('/favorite', FavoriteController::class, 'getFavorite');
$app->postRoute('/remove-favorite', FavoriteController::class, 'removeFavorite', ProductRequest::class );

$app->run();






