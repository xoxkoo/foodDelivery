<div class="item <?= (isset($item->saved)) ? 'saved' : '' ?>" id="item_<?= $item->id ?>">
    <a class="item-img" href="produkt?id=<?= $item->id ?>"><img src="<?= $item->image_link ?>" alt="obrázok produktu"></a>
    <div class="col">
        <div>
            <a href="produkt?id=<?= $item->id ?>"><h1 class="item-name"><?= $item->name ?></h1></a>
            <h2 class="item-price"><?= $item->price ?> €</h2>
        </div>

        <div class="quantity">
            <button class="btn-border btn-add" data-id="<?= $item->id ?>" data-sign="minus"> &minus; </button>
            <label>
                <input name="quantity_input" min="1" max="10" value="1" type="number" readonly>
            </label>
            <button class="btn-border btn-add" data-id="<?= $item->id ?>" data-sign="plus"> &plus; </button>
        </div>
    </div>
    <div class="col icon-group">
    <a href="<?= $item->saved_link ?>" class="item-icon heart-icon saved-update">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><title>Pridať medzi obľúbené</title><path d="M12.62 20.81C12.28 20.93 11.72 20.93 11.38 20.81C8.48 19.82 2 15.69 2 8.68998C2 5.59998 4.49 3.09998 7.56 3.09998C9.38 3.09998 10.99 3.97998 12 5.33998C13.01 3.97998 14.63 3.09998 16.44 3.09998C19.51 3.09998 22 5.59998 22 8.68998C22 15.69 15.52 19.82 12.62 20.81Z" stroke="#3f424a" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </a>
        <form action="<?= BASE_URL ?>_backend/cart.php" method="POST" class="cart-update">
            <?php foreach ($item->toppings_id as $id) :?>
            <input type="hidden" name="toppings[]" value="<?= $id ?>">
            <?php endforeach; ?>
            <input type="hidden" name="add" value="<?= $item->id  ?>">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="add-icon item-icon btn-primary">
<!--                pridať-->
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24;" xml:space="preserve"><title>Pridať do košíka</title><style type="text/css">.st0{fill:none;stroke:#292D32;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;}</style><path class="st0" d="M4.8,12h14.3"/><path class="st0" d="M12,19.2V4.8"/></svg>

                <!--                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><title>Pridať</title><path d="M6 12H18" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 18V6" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>-->
            </button>
        </form>
    </div>
</div>