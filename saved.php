<?php include_once '_partials/header.php' ?>

<div class="saved-container">

    <?php

        if (! isset($_SESSION['saved']) || ! $Saved->count() ) {
            include_once '_partials/_empty.php';
        }
        else {

    ?>

    <div class="container">
        <h1 class="center title">Obľúbené ❤️</h1>

        <div class="items-container">
        <?php
            foreach($_SESSION['saved'] as $id => $quantity) {

                $item = $Products->format( $Products->getItem($id) );

                include '_partials/_saved_item.php';

            }
        ?>
        </div>
    </div>

    <?php } ?>
</div>

<?php include_once '_partials/footer.php' ?>
