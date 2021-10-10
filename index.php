<?php

    require_once '_inc/conf.php';

    $routes = [

        '/' => [
            'GET'  => 'home.php'
        ],

        '/produkt' => [
            'GET'  => 'product.php',
        ],

        '/objednavka' => [
            'GET' => 'cart.php'
        ],

        '/oblubene' => [
            'GET' => 'saved.php'
        ],

        '/profil' => [
            'GET' => 'profile.php'
        ],

        '/order' => [
            'GET' => 'order.php'
        ],

        '/password-reset' => [
            'GET' => 'forgot_password.php'
        ]

    ];

    $page   = segment(1);
    $method = $_SERVER['REQUEST_METHOD'];


    if ( ! isset( $routes["/$page"][$method] ) ) {
        include_once '404.php';
    }
    else {
        include_once $routes["/$page"][$method];
    }

