<div class="container">

    <div class="empty">
        <?php if (segment(1) == 'objednavka') : ?>
        <div>
            <div class="emoji">
                😥
            </div>

            <h1>
                Váš košík je momentálne <strong> prázdny! </strong>
            </h1>

            <a href="<?= BASE_URL ?>">
                <button class="btn btn-primary">
                    Začať nakupovať
                </button>
            </a>
        </div>
        <?php elseif (segment(1) == 'oblubene') : ?>

        <div>
            <div class="emoji">
                😥
            </div>

            <h1>
                Momentálne nemáte <strong> žiadny </strong> produkt medzi <strong> obľúbenými </strong>!
            </h1>

            <a href="<?= BASE_URL ?>">
                <button class="btn btn-primary">
                    Pridať produkty
                </button>
            </a>
        </div>

        <?php endif; ?>

    </div>
</div>
