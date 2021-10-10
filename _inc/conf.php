<?php

// Import the necessary classes
use Illuminate\Database\Capsule\Manager as Capsule;

// Initialize Composer Autoload
require_once 'vendor/autoload.php';

include 'flash.php';

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

define( 'BASE_URL', 'http://localhost/food_delivery/' );

//SENTINEL
// Setup a new Eloquent Capsule instance
$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'food_delivery',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
]);

$capsule->bootEloquent();

// Using Medoo namespace
use Medoo\Medoo;

// Initialize database
$db = new Medoo([
    'database_type' => 'mysql',
    'database_name' => 'food_delivery',
    'server'      => 'localhost',
    'username'    => 'root',
    'password'    => '',
    'charset'     => 'utf8'
]);

require_once 'general_functions.php';
require_once 'classes/User.php';
require_once 'classes/Product.php';
require_once 'classes/Cart.php';
require_once 'classes/Saved.php';
require_once 'classes/Order.php';

// my classes
$User = new User($db);
$Cart = new Cart($db);
$Products = new Products($db);
$Saved = new Saved($db);
$Order = new Order($db);

//$User->sentinel::removeCheckpoint('activation');