<?php


require_once './../Controller/UserController.php';
require_once './../Controller/CartController.php';
require_once './../Controller/ProductController.php';

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestUri === '/login'){
    if ($requestMethod === 'GET'){
        require_once './../View/get_login.php';
    } else if ($requestMethod === 'POST'){
        $user = new UserController();
        $user->login();
    } else {
        echo 'Invalid request method ';
    }
} elseif ($requestUri === '/registrate'){
    if ($requestMethod === 'GET'){
        require_once './../View/get_registration.php';
    } else if ($requestMethod === 'POST'){
        $user = new UserController();
        $user->registrate();;
    } else {
        echo 'Invalid request method';
    }
} elseif ($requestUri === '/catalog'){
    if ($requestMethod === 'GET'){
      $product = new ProductController();
      $product->getAll();
    }else {
        echo 'Invalid request method';
    }
} elseif ($requestUri === '/add-product') {
    if ($requestMethod === 'GET') {
        require_once './../View/get_add-product.php';
    } else if ($requestMethod === 'POST') {
      $userProduct = new CartController();
      $userProduct->addProduct();
    } else {
        echo 'Invalid request method';
    }

}
elseif ($requestUri === '/cart'){
    if ($requestMethod === 'GET'){
        $cart = new CartController();
        $cart->getAll();
    }else {
        echo 'Invalid request method';
    }
}
elseif ($requestUri === '/catalog2'){
    if ($requestMethod === 'GET'){
        $product = new ProductController();
        $product->getAll();
    }else {
        echo 'Invalid request method';
    }
}
elseif ($requestUri === '/logout'){
    if ($requestMethod === 'GET') {
    $user = new UserController();
    $user->logout();
    }
}
else require_once './404.php';