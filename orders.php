<?php

    require_once '_inc/conf.php';

    if ( ! $User->is_logged() || ! $User->is_admin() )
        redirect('profil', '', 403);

    $status = ( isset($_GET['status']) ) ? $_GET['status'] : 0;
    $page = ( isset($_GET['page']) ) ? $_GET['page'] : 0;

    $orders = $Order->getOrders($status, (isset($_GET['page'])) ? $_GET['page'] * 20 : 0, 20);
    $all = $Order->count($status);

    $nextPage = (isset($_GET['page'])) ? '&page=' . ($_GET['page'] + 1) : '&page=1';
    $previousPage = (isset($_GET['page'])) ? '&page=' . ($_GET['page'] - 1) : '';

    $statusLink = '?status=' . $status;

    $previous = BASE_URL . 'orders.php' . $statusLink . $previousPage;
    $next = BASE_URL . 'orders.php' . $statusLink . $nextPage;

    include_once '_partials/header.php';
?>

<div class="container orders-container">
    <h1 class="order-title">História Objednávok 📦</h1>
    <ul class="order-navigation">
        <li <?= ($status == 0) ? 'class="selected"' : '' ?>><a href="<?=BASE_URL?>orders.php">Všetky Objednávky</a></li>
        <li <?= ($status == 1) ? 'class="selected"' : '' ?>><a href="<?=BASE_URL?>orders.php?status=1">Nevidené</a></li>
        <li <?= ($status == 2) ? 'class="selected"' : '' ?>><a href="<?=BASE_URL?>orders.php?status=2">Neodoslané</a></li>
        <li <?= ($status == 3) ? 'class="selected"' : '' ?>><a href="<?=BASE_URL?>orders.php?status=3">Dokončené</a></li>
    </ul>
    <ul class="responsive-table">
        <li class="table-header">
            <a href="#">
                <div class="cell col-1">Id</div>
                <div class="cell col-2">Dátum vytvorenia</div>
                <div class="cell col-3">Miesto</div>
                <div class="cell col-4">Status</div>
            </a>
        </li>

        <?php

            if ($orders && count($orders)) :
                foreach ($orders as $order) :
                    $order = $Order->formatOrder($order);

        ?>

        <li class="table-row">
            <a href="<?= $order->link ?>">
                <div class="cell col-1" data-label="Id"># <?= $order->id ?></div>
                <div class="cell col-2" data-label="Dátum vytvorenia"><?= $order->created_at ?></div>
                <div class="cell col-3" data-label="Miesto"><?= $order->address ?></div>
                <div class="cell col-4 status-cell status-<?= $order->status_code ?>" data-label="Status"><?= $order->status ?></div>
            </a>
        </li>

        <?php endforeach ?>
        <?php endif; ?>
    </ul>
    <div class="row page-navigation">
        <?php if ($page) : ?>
        <a class="link left" href="<?=$previous?>">< predchádzajúca strana</a>
        <?php endif; ?>

        <?php if ($all > ($page + 1) * 20) : ?>
        <a class="link right" href="<?=$next?>">ďalšia strana ></a>
        <?php endif; ?>
    </div>
</div>


<?php include_once '_partials/footer.php' ?>