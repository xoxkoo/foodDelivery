<?php
    include_once '_partials/header.php';

    $category = (isset($_GET['category'])) ? $_GET['category'] : 'pizza';

    $items = $Products->getAllBase($category);

?>

    <div class="container">
        <div class="categories row">
            <a href="?category=pizza" class="category btn-border"> pizza </a>
            <a href="?category=hamburger" class="category btn-border"> hamburger </a>
        </div>
    </div>

    <div class="container">
        <div class="items-container">

        <?php
        
            if (!$items)
                include_once '_partials/_empty_products.php';
            else {
                foreach($items as $item) {
                    $item['toppings_id'] = $Products->getToppingsByItem($item['id']);
                    $item = $Products->format($item);

                    include '_partials/_item.php';
                }
            }

        ?>

        </div>
    </div>

<?php include_once '_partials/footer.php'; ?>
