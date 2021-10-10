<div class="container">
    <h1 class="center title">Zmena hesla 🤩</h1>
    <h3 class="center post-title">Zadajte nové heslo. Vaše heslo nesmie byť rovnaké ako predchádzajúce heslo!</h3>

    <form action="<?=BASE_URL?>_backend/auth.php?update" method="post" class="form-profile">
        <div class="form-group">
            <label for="password" class="label label-text">Heslo</label>
            <label class="label label-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 10V8C6 4.69 7 2 12 2C17 2 18 4.69 18 8V10" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 18.5C13.3807 18.5 14.5 17.3807 14.5 16C14.5 14.6193 13.3807 13.5 12 13.5C10.6193 13.5 9.5 14.6193 9.5 16C9.5 17.3807 10.6193 18.5 12 18.5Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M17 22H7C3 22 2 21 2 17V15C2 11 3 10 7 10H17C21 10 22 11 22 15V17C22 21 21 22 17 22Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></label>
            <input class="input" type="password" name="password" id="password" required autofocus>
        </div>

        <div class="form-group">
            <label for="password-repeat" class="label label-text">Zopakujte heslo</label>
            <label class="label label-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 10V8C6 4.69 7 2 12 2C17 2 18 4.69 18 8V10" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 18.5C13.3807 18.5 14.5 17.3807 14.5 16C14.5 14.6193 13.3807 13.5 12 13.5C10.6193 13.5 9.5 14.6193 9.5 16C9.5 17.3807 10.6193 18.5 12 18.5Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M17 22H7C3 22 2 21 2 17V15C2 11 3 10 7 10H17C21 10 22 11 22 15V17C22 21 21 22 17 22Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></label>
            <input class="input" type="password" name="password-repeat" id="password-repeat" required>
        </div>

        <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
        <input type="hidden" name="code" value="<?= $_GET['code'] ?>">

        <div class="row">
            <a href="<?= BASE_URL . 'profil' ?>" class="btn btn-back btn-lg"> spať </a>
            <button type="submit" class="btn btn-primary btn-lg">Potvrdiť</button>
        </div>
    </form>
</div>