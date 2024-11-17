<?php
require_once './../Core/Autoloader.php';

use Controller\CartController;
use Controller\FavoriteController;
use Controller\OrderController;
use Controller\ProductController;
use Controller\UserController;
use Core\App;
use Core\Autoloader;
use Core\Container;
use Request\LoginRequest;
use Request\OrderRequest;
use Request\ProductRequest;
use Request\RegistrateRequest;
use Service\Logger\LoggerFileService;
use Controller\ProductCardController;
use Request\ReviewRequest;
use Controller\ReviewController;

$path = __DIR__;
$path = dirname($path);
Autoloader::registrate($path);

$loggerService = new LoggerFileService();
$container = new Container();
$container->set(CartController::class, function (Container $container) {
    $authService = $container->get(Service\Authentication\AuthServiceInterface::class);
    $cartService = new \Service\CartService();
    return new CartController($authService,$cartService);
});

$container->set(OrderController::class, function (Container $container) {
    $authService = $container->get(Service\Authentication\AuthServiceInterface::class);
    $orderService = new \Service\OrderService();
    $cartService = new \Service\CartService();

    return new OrderController($authService,$cartService, $orderService);
});

$container->set(ProductController::class, function ($container) {
    $authService = $container->get(Service\Authentication\AuthServiceInterface::class);
    $cartService = new \Service\CartService();

    return new ProductController($authService,$cartService);
});

$container->set(FavoriteController::class, function ($container) {
    $authService = $container->get(Service\Authentication\AuthServiceInterface::class);
    return new FavoriteController($authService);
});

$container->set(Service\Authentication\AuthServiceInterface::class, function (Container $container) {
  return new Service\Authentication\AuthenticationSession;
});

$container->set(\Service\Logger\LoggerServiceInterface::class, function (Container $container) {
    return new LoggerFileService();
});

$container->set(ProductCardController::class, function (Container $container) {
    $authService = $container->get(Service\Authentication\AuthServiceInterface::class);
    $gradeService = new \Service\GradeService();
    $orderService = new \Service\OrderService();
    return new ProductCardController($authService,$gradeService,$orderService);
});

$container->set(ReviewController::class, function (Container $container) {
    $authService = $container->get(Service\Authentication\AuthServiceInterface::class);
    $gradeService = new \Service\GradeService();
    $orderService = new \Service\OrderService();
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
$app->postRoute('/add-comment-product', \Controller\ReviewController::class, 'addReview', ReviewRequest::class );

$app->run();






