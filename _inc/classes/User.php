<?php

use Cartalyst\Sentinel\Native\Facades\Sentinel;

class User
{

    public $user;

    private $db;

    /**
     * @var Sentinel
     */
    public $sentinel;
    private $Reminder;

    public function __construct($db) {
        $this->db = $db;
        $this->sentinel = new Cartalyst\Sentinel\Native\Facades\Sentinel();

        $this->user = $this->getUser();
    }

    public function is_logged() {
        if ($this->sentinel::forceCheck())
            return true;
        else
            return false;
        
    }

    public function is_admin() {
        if ($this->user && $this->sentinel::inRole('admin'))
            return true;
        else
            return false;
    }

    public function getUser() {
        return $this->sentinel::getUser();
    }

    public function getUserId() {
        return $this->sentinel::getUser()['id'];
    }

    public function login($user) {

        if (isset($_POST['remember']) && $_POST['remember'] == 'on')
            $remember = true;
        else
            $remember = false;

        if ($this->sentinel::forceAuthenticate($user)) {
            $user = $this->sentinel::findByCredentials($user);

            if ( $remember ) {
                if ($this->sentinel::loginAndRemember($user))
                    return true;
            }
            else {
                if ($this->sentinel::login($user))
                    return true;
            }
        }
        else {
            flash()->error('Meno alebo heslo nie je správne!');
            return false;
        }
    }

    public function register($user) {

        if ($this->validateForRegister($user)) {

            $user = $this->sentinel::register($user);

            if ($user) {
//                if ($this->sendActivationCode($user))
//                    flash()->success('Aktivačný mail bol odoslaný. Dokončite Prosím registráciu!');
                // $this->sendActivationCode($user);
                return true;
            }
            else
                return false;
        }
        else {
            return false;
        }

    }

    /**
     * sending email with activation code
     *
     * @param $user
     * @return bool
     * @todo send email with button to activate
     */
    public function sendActivationCode($user) {
        $Activation = $this->sentinel::getActivationRepository();
        $activation = $Activation->create($user);

        $link = "_backend/auth.php?activation&id=$user->id&token=$activation->code";

        redirect($link);

//        return true;
    }

    public function sendResetCode($email) {

        $user = $this->sentinel::findUserByCredentials([
            'email' => $email
        ]);

        if ($user) {
            $this->Reminder = $this->sentinel::getReminderRepository();
            $reminder = $this->Reminder->create($user);

            $link = BASE_URL . "_backend/forgot_password.php?id=$user->id&token=$reminder->code";

            $this->sendResetEmail($user->email, $link);

            // if ($this->sendResetEmail($user->email, $link)) {
            //     flash()->success('Email na obnovu hesla bol úspešne odoslaný!');
            //     redirect('profil');
            // }
            // else {
            //     flash()->error('Email na obnovu hesla sa nepodarilo odoslať. Skúste to znova neskôr!');
            //     redirect('profil');
            // }
            
        }
        else
            flash()->error('Zadaný email nie je registrovaný!');
            redirect('password-reset');

    }

    private function sendResetEmail ($email, $link) {
        $from = 'From: anton.durcak22@gmail.com';
        $htmlContent = '
            <html lang="sk">
                <head>
                    <title>Resetovanie Hesla</title>
                    <style>
                        @import url("https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap");
                        body{font-family:Montserrat,sans-serif}.container{width:80%;margin:0 auto}a{text-decoration:none}h1{text-align:center;margin-bottom:1.5em}.btn{font-size:1.2rem;color:#fff;border-radius:1.3rem;background:#101010;border:1.6px solid #101010;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;width:-webkit-max-content;width:-moz-max-content;width:max-content;margin:auto;padding:.8em 2.25em;cursor:pointer;-webkit-transition:.35s;-o-transition:.35s;transition:.35s}.btn:focus,.btn:hover{-webkit-box-shadow:0 0 1.5rem .05rem rgba(16,16,16,.3);box-shadow:0 0 1.5rem .05rem rgba(16,16,16,.3);background:#222}
                    </style>
            
                </head>
                <body>
                    <div class="container">
                        <h1>Bola zaznamenaná žiadosť pre resetovanie hesla!</h1>
                        <p>Na resetovanie hesla, kliknite na toto tlačidlo:</p>
                        <a href="\'. $link .\'" class="btn">Resetovať heslo</a>
                    </div>
                </body>
            </html>';
        $subject = 'Resetovanie hesla na stránke Food Delivery';

        //send email
        $mail = mail($email, $subject, $htmlContent, $from);

        print_r($htmlContent);

        if ($mail)
            return true;
        else
            return false;
    }

    /**
     * actually activating user
     *
     * @param $id
     * @param $code
     * @return bool
     */
    public function activate($id, $code) {

        if (! $id || ! $code)
            return false;

        $user = $this->sentinel::findById($id);

        $Activation = $this->sentinel::getActivationRepository();

        if (! $user || ! $Activation->exists($user))
            return false;

        if ($Activation->complete($user, $code))
            return true;
        else
            return false;
    }

    private function validateForRegister($user) {
        if ($this->checkUser($user)) {
            flash()->error('Tento email už je obsadený!');
        }

        if (! $this->sentinel::validForCreation($user)) {
            flash()->error('Zadané údaje nie sú správne!');
        }

        if ( strlen($user['password']) < 6) {
            flash()->error('Heslo musí mať dĺžku minimálne 6 znakov!');
        }

        if (flash()->hasMessages()) return false;
        else return true;
    }

    private function checkUser($email) {
        return $this->sentinel::findByCredentials($email);
    }

    public function logout() {
        if ($this->sentinel::logout($this->user))
            return true;
        else
            return false;
    }

    private function validateForUpdate($array) {
        $id = $array['id'];
        $password = $array['password'];
        $repeat = $array['password-repeat'];

        if ($password === $repeat) {

            if ( strlen($password) < 6) {
                flash()->error('Heslo musí mať dĺžku minimálne 6 znakov!');
            }

            $this->Reminder = $this->sentinel::getReminderRepository();
            $user = $this->sentinel::findById($id);

            if ( ! $this->Reminder->exists($user) )
                flash()->error('Kód na zmenu hesla neexistuje, musíte vygenerovať nový!');

            $credentials = [
                'password' => $password
            ];

            $valid = $this->sentinel::validForUpdate($user, $credentials);

            if (! $valid)
                flash()->error('Musíte zvoliť iné heslo!');

        }
        else
            flash()->error('Heslá musia byť rovnaké!');

        if (flash()->hasMessages())
            return false;
        else
            return true;

    }

    public function updatePassword($array) {

        if ($this->validateForUpdate($array)) {

            $code = $array['code'];
            $password = $array['password'];
            $user = $this->sentinel::findById($array['id']);

            if ($this->Reminder->complete($user, $code, $password) )
                return true;
            else
                return false;

        }
        else
            return false;
    }

    /**
     * Initialize stuff
     *
     * @param $firstTime
     */
    public function init($firstTime) {
        if ($firstTime) {
            $this->sentinel::getRoleRepository()->createModel()->create([
                'name' => 'Admin',
                'slug' => 'admin',
            ]);

            $role = $this->sentinel::findRoleByName('Admin');
            $user = $this->sentinel::findUserById(1);
            $role->users()->attach($user);
        }
    }
}