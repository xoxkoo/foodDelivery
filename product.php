<?php

    include_once '_partials/header.php';

    if (! isset($_GET['id']) || ! $_GET['id']) {
        include_once '404.php';
        die();
    }

    $item = $Products->format( $Products->getItem($_GET['id']) );

    if (!$item->id) {
        include_once '404.php';
        die();
    }

    $toppings = $Products->getToppings($item->category);

    $toppings = $Products->sortToppings($toppings, $item->toppings_id);

?>

    <div class="item product <?= (isset($item->saved)) ? 'saved' : '' ?>" id="item_<?= $item->id ?>">
        <img src="<?= $item->image_link ?>" alt="obrázok produktu">
        <div class="product-container">
            <div class="row">
                <h1 class="title"><?= $item->name ?></h1>
                <a href="<?= $item->saved_link ?>" class="item-icon saved-update heart-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><title>Pridať medzi obľúbené</title><path d="M12.62 20.81C12.28 20.93 11.72 20.93 11.38 20.81C8.48 19.82 2 15.69 2 8.68998C2 5.59998 4.49 3.09998 7.56 3.09998C9.38 3.09998 10.99 3.97998 12 5.33998C13.01 3.97998 14.63 3.09998 16.44 3.09998C19.51 3.09998 22 5.59998 22 8.68998C22 15.69 15.52 19.82 12.62 20.81Z" stroke="#3f424a" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
            </div>

            <div class="row">
                <h2 class="price"><?= $item->price ?> €</h2>
                <div class="quantity">
                    <button class="btn-border btn-add" data-id="<?= $item->id ?>" data-sign="minus"> &minus; </button>
                    <label>
                        <input name="quantity_input" min="1" max="10" value="1" type="number" readonly>
                    </label>
                    <button class="btn-border btn-add" data-id="<?= $item->id ?>" data-sign="plus"> &plus; </button>
                </div>
            </div>

            <div class="line"></div>

            <form action="<?= BASE_URL ?>_backend/cart.php" method="POST" class="cart-update">
                <div class="toppings">
                    <?php foreach ($toppings as $topping) : ?>

                    <div class="topping">
                        <label class="control checkbox control-x">
                            <input type="checkbox" <?= (in_array($topping['id'], $item->toppings_id)) ? 'checked' : '' ?> value="<?= $topping['id'] ?>" name="toppings[]">
                            <span class="control-indicator"></span>
                            <?= $topping['topping'] ?>
                        </label>
                    </div>

                    <?php endforeach; ?>
                    <div class="faded right">* za prílohy navyše sa pripláca</div>
                </div>
                <input type="hidden" name="add" value="<?= $item->id  ?>">
                <input type="hidden" name="quantity" value="1">
                <div class="row">
                    <a class="btn btn-back" href="<?=BASE_URL?>">spať</a>
                    <button type="submit" class="btn btn-primary cart-update">Pridať</button>
                </div>
            </form>
        </div>
    </div>

<?php include_once '_partials/footer.php' ?>
