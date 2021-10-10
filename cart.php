<?php include_once '_partials/header.php' ?>

<div class="container">
    <?php

        if (! isset($_SESSION['cart']) || ! $Cart->count() ) :
            include_once '_partials/_empty.php';
        else :
            $time = new DateTime();
            $time->add(new DateInterval('PT' . 30 . 'M'));

            $time1 = $time->format('H:i');
            $time->add(new DateInterval('PT' . 20 . 'M'));

            $time2 = $time->format('H:i');
    ?>
    <h1 class="center title">Košík 🛒️</h1>

    <div class="cart">


        <div class="items-container">
        <?php
            $price = 0;
            $delivery = 0.60;

            foreach($Cart->getAll() as $key => $item) {

                $item = $Products->formatCart($item, $key);

                $price += $item->final_price;

                include '_partials/_cart_item.php';

            }
        ?>
        </div>

        <div class="cart-info-parent">
            <div class="cart-info">
                <div class="container">
                    <div class="swipe"></div>

                    <div class="row">
                        <h2>Celkom</h2>
                        <h2><?= $Products->moneyFormat($price) ?> €</h2>
                    </div>

                    <div class="row">
                        <h2>Doprava</h2>
                        <h2><?= $Products->moneyFormat($delivery) ?> €</h2>
                    </div>

                    <div class="row">
                        <div class="line"></div>
                    </div>

                    <div class="row">
                        <h1>Spolu</h1>
                        <h1><?= $Products->moneyFormat($price + $delivery) ?> €</h1>
                    </div>

                    <div class="faded center">
                        <svg style="margin-right: 1em" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14"><g transform="translate(-98 -523)"><g id="Ellipse_21" data-name="Ellipse 21" transform="translate(98 523)" fill="none" stroke="#EEF8FF" stroke-width="1"><circle cx="7" cy="7" r="7" stroke="none"/><circle cx="7" cy="7" r="6.5" fill="none"/></g><line id="Line_27" data-name="Line 27" x2="3" transform="translate(105.5 530.5)" fill="none" stroke="#EEF8FF" stroke-linecap="round" stroke-width="1"/><line id="Line_28" data-name="Line 28" x2="3" y2="3" transform="translate(102.5 527.5)" fill="none" stroke="#EEF8FF" stroke-linecap="round" stroke-width="1"/></g></svg>
                        Predpokladaný čas donášky <?= "$time1 - $time2" ?>
                    </div>

                    <a href="<?= BASE_URL ?>order" class="btn btn-light">Objednávka</a>
                    <div class="faded right" style="margin-top: 1em">s povinnosťou platby</div>

                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php include_once '_partials/footer.php' ?>
