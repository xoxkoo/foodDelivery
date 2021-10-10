<?php
    require_once '../_inc/conf.php';

    if (! isset($_POST['add']) && ! isset($_POST['remove'])) {
        redirect('back');
    }
    if ( isset($_POST['add'])) {
        if (isset($_POST['quantity']) && isset($_POST['toppings']))
            $Cart->addProduct($_POST['add'], $_POST['quantity'], $_POST['toppings']);
        else
            die('error');
    }

    if ( isset($_POST['remove']) && is_numeric($_POST['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_POST['remove']]) ) {
        $Cart->removeProduct($_POST['remove']);
    }