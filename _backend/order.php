<?php

require_once '../_inc/conf.php';

if (!$Cart->count()) {
    flash()->warning('Košík je prázdny!');
    redirect('/');
}

if (! $Order->validate($_POST, $Cart->getAll())) {
    flash()->error('Niečo sa pokazilo, skúste to znova neskôr!');
    redirect('back');
}
else {
    if ($Order->create() ) {
        flash()->success('Objednávka bola úspešne vytvorená!');
        redirect('/');
    }
    else {
        flash()->error('Niečo sa pokazilo, skúste to znova neskôr!');
        redirect('back');
    }
}

