<div class="item cart-item" id="item_<?= $item->id ?>">
    <a class="item-img" href="produkt?id=<?= $item->id ?>"><img src="<?= $item->image_link ?>" alt="obrázok produktu"></a>
    <div class="col">
        <div>
            <a href="produkt?id=<?= $item->id ?>"><h1 class="item-name"><?= $item->name ?></h1></a>
            <p class="faded"><?= $item->toppings ?></p>
        </div>
        <h2 class="item-price"><?= $item->final_price ?> € </h2>
    </div>
    <div class="col icon-group">
        <form action="<?=BASE_URL?>_backend/cart.php" method="post" class="cart-update">
            <button type="submit" class="item-icon cross-icon hide-item"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><defs></defs><title>Odobrať</title><g id="Shopicon"><path d="M35.31,12.69h0A.93.93,0,0,0,34,12.6l-.09.09L24,22.59l-9.9-9.9a1,1,0,0,0-1.33-.09l-.08.09h0A.93.93,0,0,0,12.6,14l.09.09,9.9,9.9-9.9,9.9a1,1,0,0,0-.09,1.33l.09.08h0A.93.93,0,0,0,14,35.4l.09-.09,9.9-9.9,9.9,9.9a1,1,0,0,0,1.33.09l.08-.09h0A.93.93,0,0,0,35.4,34l-.09-.09L25.41,24l9.9-9.9a1,1,0,0,0,.09-1.33Z"/></g></svg></button>
            <input type="hidden" name="remove" value="<?= $item->cart_id ?>">
        </form>
        <div>
           <strong> <?= $item->quantity ?> </strong> x
        </div>
    </div>
</div>
