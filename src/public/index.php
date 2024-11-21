<?php

require './../../vendor/autoload.php';

use Aldar\Project2\Controller\CartController;
use Aldar\Project2\Controller\FavoriteController;
use Aldar\Project2\Controller\OrderController;
use Aldar\Project2\Controller\ProductController;
use Aldar\Project2\Controller\UserController;
use Core\App;
use Core\Autoloader;
use Core\Container;
use Aldar\Project2\Request\LoginRequest;
use Aldar\Project2\Request\OrderRequest;
use Aldar\Project2\Request\ProductRequest;
use Aldar\Project2\Request\RegistrateRequest;
use Aldar\Project2\Service\Logger\LoggerFileService;
use Aldar\Project2\Controller\ProductCardController;
use Aldar\Project2\Request\ReviewRequest;
use Aldar\Project2\Controller\ReviewController;
use Core\Authentication\AuthServiceInterface;
use Aldar\Project2\Service\OrderService;
use Aldar\Project2\Service\CartService;
use Aldar\Project2\Service\GradeService;
use Aldar\Project2\Service\Logger\LoggerServiceInterface;



//$path = 'var/www/html/src';
//Autoloader::registrate($path);



$container = new Container();
$loggerService = new LoggerFileService();
$container->set(CartController::class, function (Container $container) {
    $authService = $container->get(AuthServiceInterface::class);

    $cartService = new CartService();
    return new CartController($authService,$cartService);
});

$container->set(OrderController::class, function (Container $container) {
    $authService = $container->get(AuthServiceInterface::class);
    $orderService = new OrderService();
    $cartService = new CartService();

    return new OrderController($authService,$cartService, $orderService);
});

$container->set(ProductController::class, function ($container) {
    $authService = $container->get(AuthServiceInterface::class);
    $cartService = new CartService();

    return new ProductController($authService,$cartService);
});

$container->set(FavoriteController::class, function ($container) {
    $authService = $container->get(AuthServiceInterface::class);
    return new FavoriteController($authService);
});

$container->set(AuthServiceInterface::class, function (Container $container) {
  return new \Aldar\Project2\Service\Authentication\AuthenticationSession();
});

$container->set(LoggerServiceInterface::class, function (Container $container) {
    return new LoggerFileService();
});

$container->set(ProductCardController::class, function (Container $container) {
    $authService = $container->get(AuthServiceInterface::class);
    $gradeService = new GradeService();
    $orderService = new OrderService();
    return new ProductCardController($authService,$gradeService,$orderService);
});

$container->set(ReviewController::class, function (Container $container) {
    $authService = $container->get(AuthServiceInterface::class);
    $gradeService = new GradeService();
    $orderService = new OrderService();
    return new ReviewController($authService, $gradeService, $orderService);
});


$app = new App($loggerService, $container);
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
$app->postRoute('/product-card', ProductCardController::class, 'getProductCard', ProductRequest::class );
$app->postRoute('/add-comment-product', ReviewController::class, 'addReview', ReviewRequest::class );

$app->run();






