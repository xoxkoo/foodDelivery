<?php

    include_once '_partials/header.php';

    $towns = $Order->getTowns();

?>

    <div class="container">
        <h1 class="center title">Objednávka 📦</h1>
        <form action="<?= BASE_URL ?>_backend/order.php" method="POST" class="order">
            <div class="form-group">
                <label for="email" class="label label-text">Email</label>
<!--                <label for="email" class="label label-icon"><svg id="icon-email" xmlns="http://www.w3.org/2000/svg"  height="48" viewBox="0 0 48 48" width="48"><g><path d="M40,8H8c-2.2,0-4,1.8-4,4v24c0,2.2,1.8,4,4,4h32c2.2,0,4-1.8,4-4V12C44,9.8,42.2,8,40,8z M8,10h32c0.701,0,1.317,0.364,1.674,0.912L24,28.586L6.326,10.912C6.683,10.364,7.299,10,8,10z M40,38H8c-1.103,0-2-0.897-2-2V13.414l18,18l18-18V36C42,37.103,41.103,38,40,38z"/></g></svg></label>-->
                <input class="input" type="email" name="email" id="email" value="<?=(isset($User->user->email)) ? $User->user->email : ''?>" required autocomplete="on" autofocus>
            </div>

            <div class="form-group">
                <label for="phone" class="label label-text">Tel. číslo</label>
<!--                <label for="phone" class="label label-icon"><svg xmlns="http://www.w3.org/2000/svg"  height="48" viewBox="0 0 48 48" width="48"><g id="Shopicon"><rect x="21" y="10" width="6" height="2"/><circle cx="24" cy="36" r="2"/><path d="M32,44c2.2,0,4-1.8,4-4V8c0-2.2-1.8-4-4-4H16c-2.2,0-4,1.8-4,4v32c0,2.2,1.8,4,4,4H32z M14,40V8c0-1.103,0.897-2,2-2h16c1.103,0,2,0.897,2,2v32c0,1.103-0.897,2-2,2H16C14.897,42,14,41.103,14,40z"/></g></svg></label>-->
                <input class="input" name="phone" id="phone" required autocomplete="on">
            </div>

            <div class="select form-group">
                <select aria-label="Select menu example" name="town" class="input" id="town">
                    <option selected>Vyberte mesto</option>
                    <?php foreach ($towns as $town) : ?>
                        <option value="<?=(int)$town['id']?>"><?=$town['name']?>  <?= ($town['price'] != null) ? '(+' . $town['price'] . '€)' : '' ?> </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="address" class="label label-text">Ulica a číslo domu</label>
<!--                <label for="town" class="label label-icon"><svg xmlns="http://www.w3.org/2000/svg"  height="48" viewBox="0 0 48 48" width="48"><g id="Shopicon"><path d="M4,20h4v24h10h12h10V20h4L24,4L4,20z M20,42V26h8v16H20z M38,18v24h-8V24H18v18h-8V18H9.702L24,6.561L38.298,18H38z"/></g></svg></label>-->
                <input class="input" name="address" id="address" required autocomplete="on">
            </div>

            <div class="form-group">
                <label for="note" class="label label-text label-textarea">Poznámka</label>
                <textarea class="input" name="note" id="note" cols="30" rows="10"></textarea>
                <div class="faded right">* dodatočné informácie k objednávke alebo doručeniu</div>
            </div>

            <div class="row">
                <a class="btn btn-back" href="<?=BASE_URL?>objednavka">spať</a>
                <button type="submit" class="btn btn-primary">Objednať</button>
            </div>
            <div class="center">
                <div class="btn btn-border" style="font-size: .8rem">
                    alebo objednať telefonicky: <strong> <a href="tel: 000000000"> +421 951 167 885</a> </strong>
                </div>
            </div>
        </form>
    </div>

<?php include_once '_partials/footer.php' ?>
