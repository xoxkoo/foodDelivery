<div class="item" id="item_<?= $item->id ?>">
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
        <a href="<?=BASE_URL?>_backend/saved.php?remove=<?= $item->id ?>" class="item-icon cross-icon hide-item saved-update"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><defs></defs><title>Odobrať</title><g id="Shopicon"><path d="M35.31,12.69h0A.93.93,0,0,0,34,12.6l-.09.09L24,22.59l-9.9-9.9a1,1,0,0,0-1.33-.09l-.08.09h0A.93.93,0,0,0,12.6,14l.09.09,9.9,9.9-9.9,9.9a1,1,0,0,0-.09,1.33l.09.08h0A.93.93,0,0,0,14,35.4l.09-.09,9.9-9.9,9.9,9.9a1,1,0,0,0,1.33.09l.08-.09h0A.93.93,0,0,0,35.4,34l-.09-.09L25.41,24l9.9-9.9a1,1,0,0,0,.09-1.33Z"/></g></svg></a>
        <form action="<?= BASE_URL ?>_backend/cart.php" method="POST" class="cart-update">
            <?php foreach ($item->toppings_id as $id) :?>
            <input type="hidden" name="toppings[]" value="<?= $id ?>">
            <?php endforeach; ?>
            <input type="hidden" name="add" value="<?= $item->id  ?>">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="add-icon item-icon btn-primary"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><title>Pridať</title><path d="M6 12H18" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 18V6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </button>
        </form>
    </div>
</div>
