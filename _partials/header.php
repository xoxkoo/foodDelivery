<?php require_once '_inc/conf.php' ?>

<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Food delivery">
    <title>Food Delivery | <?= ( segment(1) ) ? ucfirst( segment(1) ) : "Domov" ?></title>

    <link rel="stylesheet" href="<?= BASE_URL . 'assets/css/wtf-forms.css' ?>">
    <link rel="stylesheet" href="<?= BASE_URL . 'assets/css/style.min.css' ?>">

    <link rel="shortcut icon" href="<?= BASE_URL ?>favicon.ico" type="image/x-icon">

</head>
<body>
<script type="text/javascript">
    function getCart() {
        return <?= isset($_SESSION['cart']) ? $Cart->formatForJS($_SESSION['cart']) : '' ?>
    }

    function getSaved() {
        return <?= isset($_SESSION['saved']) ? json_encode($_SESSION['saved']) : '' ?>
    }
</script>

<?php

    $User->init(false);

    /**
     * remove products which don't exist from cart and saved
     */
    if ( isset( $_SESSION['cart'] ) ) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if (! $Products->getItemBase($item['id'])) {
                $Cart->removeProduct($key);
            }
        }
    }

    if ( isset( $_SESSION['saved'] ) ) {
        foreach ($_SESSION['saved'] as $key) {
            if (! $Products->getItemBase($key)) {
                $Saved->removeProduct($key);
            }
        }
    }

    // Get the amount of items, this will be displayed in the header.
    $cartItems = $Cart->count();
    $savedItems = $Saved->count();

//    flash()->error('aaaaa');
?>
<?= flash()->display(); ?>
<main class="<?= ( segment(1) ) ? segment(1) : "domov" ?>">

    <a class="skip-link" href="#maincontent">Skočiť</a>

    <header>
        <div class="header container">

            <div class="profile-group">
                <a href="<?= BASE_URL ?>profil" class="profile btn-border" aria-label="profil">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.1601 10.87C12.0601 10.86 11.9401 10.86 11.8301 10.87C9.45006 10.79 7.56006 8.84 7.56006 6.44C7.56006 3.99 9.54006 2 12.0001 2C14.4501 2 16.4401 3.99 16.4401 6.44C16.4301 8.84 14.5401 10.79 12.1601 10.87Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M7.15997 14.56C4.73997 16.18 4.73997 18.82 7.15997 20.43C9.90997 22.27 14.42 22.27 17.17 20.43C19.59 18.81 19.59 16.17 17.17 14.56C14.43 12.73 9.91997 12.73 7.15997 14.56Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <a href="<?= BASE_URL ?>oblubene" class="items-box saved-items-box" data-items="<?=$savedItems?>" aria-label="oblubene">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <title>Obľúbené</title>
                        <path d="M12.62 20.81C12.28 20.93 11.72 20.93 11.38 20.81C8.48 19.82 2 15.69 2 8.68998C2 5.59998 4.49 3.09998 7.56 3.09998C9.38 3.09998 10.99 3.97998 12 5.33998C13.01 3.97998 14.63 3.09998 16.44 3.09998C19.51 3.09998 22 5.59998 22 8.68998C22 15.69 15.52 19.82 12.62 20.81Z" stroke="#292D32" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <a href="<?= BASE_URL ?>objednavka" class="items-box cart-items-box cart-items" data-items="<?=$cartItems?>" aria-label="objednavka">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <title>Košík</title>
                        <path d="M7.5 7.67001V6.70001C7.5 4.45001 9.31 2.24001 11.56 2.03001C14.24 1.77001 16.5 3.88001 16.5 6.51001V7.89001" stroke="#292D32" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M8.99999 22H15C19.02 22 19.74 20.39 19.95 18.43L20.7 12.43C20.97 9.99 20.27 8 16 8H7.99999C3.72999 8 3.02999 9.99 3.29999 12.43L4.04999 18.43C4.25999 20.39 4.97999 22 8.99999 22Z" stroke="#292D32" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>

            <div class="logo"><a href="<?= BASE_URL ?>" aria-label="logo"> Cool logo </a></div>

            <div class="menu-icon-wrap-parent">
                <div class="menu-icon-wrap btn-border">
                    <div id="menu-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>

        </div>
    </header>
    <div class="menu">
        <ul>
            <li><a href="<?=BASE_URL?>">Domov</a></li>
            <li>Ponuka</li>
            <li>Kontakt</li>
            <?php if($User->is_admin()) : ?>
            <li><a href="<?=BASE_URL?>orders.php"> Objednávky </a></li>
            <?php endif; ?>
        </ul>
    </div>

