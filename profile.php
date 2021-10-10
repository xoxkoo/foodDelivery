<?php
include_once '_partials/header.php';

if (! $User->is_logged()) :

?>

    <div class="profile-page">
        <div class="container">
            <?php if ( isset($_GET['register'])) : ?>

            <form action="<?=BASE_URL?>_backend/auth.php?register" method="post" class="form-profile">
                <div class="form-group">
                    <label for="email" class="label label-text">Email</label>
                    <label class="label label-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17 20.5H7C4 20.5 2 19 2 15.5V8.5C2 5 4 3.5 7 3.5H17C20 3.5 22 5 22 8.5V15.5C22 19 20 20.5 17 20.5Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/><path d="M17 9L13.87 11.5C12.84 12.32 11.15 12.32 10.12 11.5L7 9" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg></label>
                    <input class="input" type="email" name="email" id="email" required autofocus>
                </div>

                <div class="form-group form-inline">
                    <div class="form-group">
                        <label for="first_name" class="label label-text">Meno</label>
                        <label class="label label-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.1601 10.87C12.0601 10.86 11.9401 10.86 11.8301 10.87C9.45006 10.79 7.56006 8.84 7.56006 6.44C7.56006 3.99 9.54006 2 12.0001 2C14.4501 2 16.4401 3.99 16.4401 6.44C16.4301 8.84 14.5401 10.79 12.1601 10.87Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M7.15997 14.56C4.73997 16.18 4.73997 18.82 7.15997 20.43C9.90997 22.27 14.42 22.27 17.17 20.43C19.59 18.81 19.59 16.17 17.17 14.56C14.43 12.73 9.91997 12.73 7.15997 14.56Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></label>
                        <input class="input" type="text" name="first_name" id="first_name" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="label label-text">Priezvisko</label>
                        <label class="label label-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.16006 10.87C9.06006 10.86 8.94006 10.86 8.83006 10.87C6.45006 10.79 4.56006 8.84 4.56006 6.44C4.56006 3.99 6.54006 2 9.00006 2C11.4501 2 13.4401 3.99 13.4401 6.44C13.4301 8.84 11.5401 10.79 9.16006 10.87Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M16.41 4C18.35 4 19.91 5.57 19.91 7.5C19.91 9.39 18.41 10.93 16.54 11C16.46 10.99 16.37 10.99 16.28 11" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M4.15997 14.56C1.73997 16.18 1.73997 18.82 4.15997 20.43C6.90997 22.27 11.42 22.27 14.17 20.43C16.59 18.81 16.59 16.17 14.17 14.56C11.43 12.73 6.91997 12.73 4.15997 14.56Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M18.3401 20C19.0601 19.85 19.7401 19.56 20.3001 19.13C21.8601 17.96 21.8601 16.03 20.3001 14.86C19.7501 14.44 19.0801 14.16 18.3701 14" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></label>
                        <input class="input" type="text" name="last_name" id="last_name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="label label-text">Heslo</label>
                    <label class="label label-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 10V8C6 4.69 7 2 12 2C17 2 18 4.69 18 8V10" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 18.5C13.3807 18.5 14.5 17.3807 14.5 16C14.5 14.6193 13.3807 13.5 12 13.5C10.6193 13.5 9.5 14.6193 9.5 16C9.5 17.3807 10.6193 18.5 12 18.5Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M17 22H7C3 22 2 21 2 17V15C2 11 3 10 7 10H17C21 10 22 11 22 15V17C22 21 21 22 17 22Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></label>
                    <input class="input" type="password" name="password" id="password" required>
                </div>

                <div class="row">
                    <a href="<?= BASE_URL ?>profil" class="btn btn-back btn-lg"> Prihlásiť </a>
                    <button type="submit" class="btn btn-primary btn-lg">Registrovať</button>
                </div>
            </form>
        </div>

            <?php else : ?>
            <form action="<?=BASE_URL?>_backend/auth.php?login" method="post" class="form-profile">
                <div class="form-group">
                    <label for="email" class="label label-text">Email</label>
                    <label class="label label-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17 20.5H7C4 20.5 2 19 2 15.5V8.5C2 5 4 3.5 7 3.5H17C20 3.5 22 5 22 8.5V15.5C22 19 20 20.5 17 20.5Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/><path d="M17 9L13.87 11.5C12.84 12.32 11.15 12.32 10.12 11.5L7 9" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg></label>
                    <input class="input" type="email" name="email" id="email" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password" class="label label-text">Heslo</label>
                    <label class="label label-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 10V8C6 4.69 7 2 12 2C17 2 18 4.69 18 8V10" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 18.5C13.3807 18.5 14.5 17.3807 14.5 16C14.5 14.6193 13.3807 13.5 12 13.5C10.6193 13.5 9.5 14.6193 9.5 16C9.5 17.3807 10.6193 18.5 12 18.5Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M17 22H7C3 22 2 21 2 17V15C2 11 3 10 7 10H17C21 10 22 11 22 15V17C22 21 21 22 17 22Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></label>
                    <input class="input" type="password" name="password" id="password" required>
                </div>

                <div class="row profile-row">
                    <label class="control checkbox">
                        <input type="checkbox" name="remember">
                        <span class="control-indicator"></span>
                        <span class="text">
                            Zapamätať si ma
                        </span>
                    </label>
                    <a href="<?=BASE_URL?>password-reset" class="link">Zabudnuté heslo?</a>
                </div>

                <div class="row">
                    <a href="<?= BASE_URL . 'profil?register' ?>" class="btn btn-back btn-lg"> Registrovať </a>
                    <button type="submit" class="btn btn-primary btn-lg">Prihlásiť</button>
                </div>
            </form>
        </div>
        <?php endif ?>
<?php else : ?>
    <h1 class="title center">Moje objednávky 📦</h1>
<?php
    include_once '_partials/_my_orders.php';
    endif;
?>


<?php include_once '_partials/footer.php' ?>
