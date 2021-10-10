<?php
    $page = ( isset($_GET['page']) ) ? $_GET['page'] : 0;
    $orders = $Order->getOrders_by_User($User->user->id, (isset($_GET['page'])) ? $_GET['page'] * 20 : 0, 20);

    $status = 0;
    $all = $Order->count_by_User($User->user->id);
    
    $nextPage = (isset($_GET['page'])) ? '?page=' . ($_GET['page'] + 1) : '&page=1';
    $previousPage = (isset($_GET['page'])) ? '?page=' . ($_GET['page'] - 1) : '';

    $previous = BASE_URL . 'profil' . $previousPage;
    $next = BASE_URL . 'profil' . $nextPage;
    
?>
<div class="container orders-container">
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

        <?php
            endforeach;
            endif;
        ?>

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

<div class="row">
    <a href="<?=BASE_URL?>_backend/auth.php?logout" class="btn btn-primary center" style="margin-top: 2em">odhlásiť</a>
</div>
