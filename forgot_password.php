<?php

require_once '_inc/conf.php';

if (isset($_GET['email'])) {
    $User->sendResetCode($_GET['email']);
}

include_once '_partials/header.php';

if (isset($_GET['new-password']))
    include_once '_partials/_new_password.php';
else
    include_once '_partials/_input_password.php';

include_once '_partials/footer.php';
