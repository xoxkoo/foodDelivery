<?php
require_once '../_inc/conf.php';

if (isset($_GET['register'])) {
    if ($User->register($_POST)) {
        flash()->success('Boli ste úspešne registrovaný!');
    }
}
else if ( isset($_GET['login']) ) {
    if ($User->login($_POST)) {
        flash()->success('Vitajte! Ste úspešne prihlásený!');
    }
}
else if (isset($_GET['logout'])) {
    if ($User->logout()) {
        flash()->success('Boli ste úspešne odhlásený!');
    }
}
else if (isset($_GET['activation'])) {
    if ($User->activate($_GET['id'], $_GET['token'])) {
        flash()->success('Váš email bol úspešne aktivovaný!');
    }
    else {
        flash()->error('Aktivácia sa nepodarila! Skúste to znova neskôr.');
    }
}
else if (isset($_GET['update'])) {

    if (isset($_POST['id']) && isset($_POST['code'])) {

        if ($User->updatePassword($_POST))
            flash()->success('Heslo bolo úspešne zmenené!');
        else
            flash()->error('Niečo sa pokazilo, skúste to znova neskôr!');

    }

}

//$ac=$User->activate(segment(4), segment(5));

redirect('profil');


