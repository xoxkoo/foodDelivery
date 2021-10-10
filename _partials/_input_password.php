<div class="container">
    <h1 class="center title">Resetovanie hesla 😶</h1>
    <h3 class="center post-title">Zadajte email spojený s vaším účtom a my vám pošleme inštrukcie na resetovanie hesla</h3>
    <form action="<?=BASE_URL?>password-reset" method="get" class="form-profile">
        <div class="form-group">
            <label for="email" class="label label-text">Email</label>
            <label class="label label-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17 20.5H7C4 20.5 2 19 2 15.5V8.5C2 5 4 3.5 7 3.5H17C20 3.5 22 5 22 8.5V15.5C22 19 20 20.5 17 20.5Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/><path d="M17 9L13.87 11.5C12.84 12.32 11.15 12.32 10.12 11.5L7 9" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg></label>
            <input class="input" type="email" name="email" id="email" required autofocus>
        </div>

        <div class="row">
            <a href="<?= BASE_URL . 'profil' ?>" class="btn btn-back btn-lg"> spať </a>
            <button type="submit" class="btn btn-primary btn-lg">Odoslať</button>
        </div>
    </form>
</div>

