<?php
    require_once '../_inc/conf.php';

    if (! isset($_GET['add']) && ! isset($_GET['remove'])) {
        redirect('back');
    }

    if (isset($_GET['add'])) {
        $Saved->addProduct($_GET['add']);
    }

    if ( isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['saved']) && isset($_SESSION['saved'][$_GET['remove']]) ) {
        $Saved->removeProduct($_GET['remove']);
    }
