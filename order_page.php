<?php

require_once '_inc/conf.php';

$order = $Order->getOrder($_GET['order']);

if ($order)
    $order = $Order->formatOrder($order);
else {
    flash()->error('Objednávka nebola nájdená');
    redirect('orders.php');
}

if ( ! $User->is_logged() || ! ($User->is_admin() || (int)$order->user_id === $User->user->id) )
    redirect('profil', '', 403);

if (isset($_GET['finish']) && $_GET['finish']) {
    if (! $User->is_logged() && ! $User->is_admin()) {
        flash()->error('Na toto nemáte oprávnenie!');
        redirect('/');
    }
    else {
        $Order->finish($_GET['order']);
        flash()->success('Objednávka číslo ' . $_GET['order'] . ' bola úspešne dokončená!');
        redirect('back');
    }
}

if (isset($_GET['delete']) && $_GET['delete']) {
    if (! $User->is_logged() && ! $User->is_admin()) {
        flash()->error('Na toto nemáte oprávnenie!');
        redirect('/');
    }
    else {
        $Order->removeOrder($_GET['order']);
        flash()->success('Objednávka číslo ' . $_GET['order'] . ' bola úspešne vymazaná!');
        redirect('orders.php');
    }
}

if ($User->is_admin())
    $Order->seen($order);

$items = $Order->getItems($order->id);

?>
<?php include_once '_partials/header.php' ?>

<div class="container order-page-container">
    <h1 class="center title">Objednávka číslo <?=$order->id?> 🍕 </h1>
    <div class="cart">
            <div class="items-container">
                <?php

                $price = 0;

                foreach ($items as $item) {
                    $item = $Products->formatCart($item, 0);
                    $price += $item->final_price;
                    
                    include '_partials/_order_item.php';
                }

                ?>
            </div>
        <div class="cart-info-parent">
            <div class="cart-info">
                <div class="container">
                    <p>Tel.: <strong> <a href="tel:<?= $order->phone ?>"> <?= $order->phone ?> </a> </strong> </p>
                    <p>Email: <strong>  <a href="mailto: <?= $order->email ?>"> <?= $order->email ?> </a> </strong> </p>
                    <p>Adresa: <strong> <?= $order->address ?> </strong> </p>
                    <p class="row">Status: <span class="status-cell status-<?= $order->status_code ?>"> <strong> <?= $order->status ?> </strong> </span></p>
                    <p>Cena celkovo: <strong> <?= $Products->moneyFormat($price) ?> € </strong> </p>
                    <?php if ($order->note) : ?>
                    <p>Poznámka: <?=$order->note?></p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

    <?php if ($User->is_admin()) : ?>

    <div class="row">
        <a class="btn btn-back" href="<?=BASE_URL?>orders.php">spať</a>
        <div class="order-action">
            <a href="<?=BASE_URL . 'order_page.php?order=' . $_GET['order'] . '&finish=true'?>">dokončiť</a>
            <a href="<?=BASE_URL . 'order_page.php?order=' . $_GET['order'] . '&delete=true'?>">vymazať</a>
        </div>
<!--        --><?php //if ($order->status_code != 3) : ?>
<!--        <a class="btn btn-primary" href="--><?//=BASE_URL . 'order_page.php?order=' . $_GET['order'] . '&finish=true'?><!--">dokončiť</a>-->
<!--        --><?php //else : ?>
<!--        <a class="btn btn-delete" href="--><?//=BASE_URL . 'order_page.php?order=' . $_GET['order'] . '&delete=true'?><!--">vymazať</a>-->
<!--        --><?php //endif; ?>
    </div>
    <?php else : ?>

<!--    <div class="row">-->
<!--        <a class="btn btn-back" href="--><?//=BASE_URL?><!--orders.php">spať</a>-->
<!--        <a class="btn btn-primary" href="--><?//=BASE_URL . 'order_page.php?order=' . $_GET['order'] . '&delete=true'?><!--">vymazať</a>-->
<!--    </div>-->

    <?php endif; ?>

</div>

<?php include_once '_partials/footer.php' ?>
