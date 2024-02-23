<?php

    require_once 'vendor/autoload.php';
    session_start();

    $router = new AltoRouter();
    $router->setBasePath('/pwd');

    // map homepage
    $router->map( 'GET', '/', function() {
        echo 'home page';
    }, 'home');

    // authentication routes
    $router->map( 'GET', '/logout', 'App\AuthenticationController#logout', 'logout');
    $router->map( 'GET|POST', '/login', 'App\AuthenticationController#login', 'login');
    $router->map( 'GET|POST', '/register', 'App\AuthenticationController#register', 'register');
    $router->map( 'GET|POST', '/profile', 'App\AuthenticationController#showProfile', 'profile');

    // shop routes
    $router->map( 'GET', '/shop', 'App\ShopController#index', 'shop');
    $router->map( 'GET', '/shop/[i:page]', 'App\ShopController#index', 'shop_paginated');
    $router->map( 'GET|POST', '/product/[i:id]', 'App\ShopController#showProduct', 'product');
    $router->map( 'GET|POST', '/cart', 'App\ShopController#showCart', 'cart');
    
    // admin home routes
    $router->map( 'GET|POST', '/admin', 'App\AdminController#index', 'admin');

    // admin users routes
    $router->map( 'GET', '/admin/users/list', 'App\AdminController#getUsersList');
    $router->map( 'GET', '/admin/users/show/[i:id]', 'App\AdminController#getUserDetails');
    $router->map( 'POST', '/admin/users/delete/[i:id]', 'App\AdminController#deleteUser');
    $router->map( 'POST', '/admin/users/edit/[i:id]', 'App\AdminController#editUser');

    // admin products routes
    $router->map( 'GET', '/admin/products/list', 'App\AdminController#getProductList');
    $router->map( 'GET', '/admin/products/show/[i:id]', 'App\AdminController#getProductDetails');
    $router->map( 'POST', '/admin/products/delete/[i:id]', 'App\AdminController#deleteProduct');
    $router->map( 'POST', '/admin/products/edit/[i:id]', 'App\AdminController#editProduct');

    // admin categories routes
    $router->map( 'GET', '/admin/categories/list', 'App\AdminController#getCategoriesList');
    $router->map( 'GET', '/admin/categories/show/[i:id]', 'App\AdminController#getCategoryDetails');
    $router->map( 'GET', '/admin/categories/delete/[i:id]', 'App\AdminController#deleteCategory');
    $router->map( 'POST', '/admin/categories/edit/[i:id]', 'App\AdminController#editCategory');

    // admin cart routes
    $router->map( 'GET', '/admin/carts/list', 'App\AdminController#getCartList');
    $router->map( 'GET', '/admin/carts/show/[i:id]', 'App\AdminController#getCartDetails');
    $router->map( 'POST', '/admin/carts/delete/[i:id]', 'App\AdminController#deleteCart');
    $router->map( 'POST', '/admin/carts/edit/[i:id]', 'App\AdminController#editCart');


    // match current request url
    $match = $router->match();

    // call closure or throw 404 status
    if (is_array($match)) {
        // call closure 
        if (is_callable($match['target'])) {
            call_user_func_array($match['target'], $match['params']);
        }
        // call method on class
        elseif (is_string($match['target'])) {
            list($class, $method) = explode("#", $match['target']);
            if (class_exists($class) && method_exists($class, $method)) {
                call_user_func_array(array(new $class, $method), $match['params']);
            } else {
                header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
            }
        }
    } else {
        // no route was matched
        header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
    }