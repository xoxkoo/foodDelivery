<div class="item cart-item" id="item_<?= $item->id ?>">
    <a class="item-img" href="produkt?id=<?= $item->id ?>"><img src="<?= $item->image_link ?>" alt="obrázok produktu"></a>
    <div class="col">
        <div>
            <a href="produkt?id=<?= $item->id ?>"><h1 class="item-name"><?= $item->name ?></h1></a>
            <p class="faded"><?= $item->toppings ?></p>
        </div>
        <h2 class="item-price"><?= $item->final_price ?> € </h2>
    </div>

    <div class="col right">
        <div class="row">
            <strong> <?= $item->quantity ?> </strong>x
        </div>
    </div>
</div>
