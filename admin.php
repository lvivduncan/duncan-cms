<?php
/* // delete install.php
if(file_exists('install.php')) {
    if(!unlink('install.php')){
        die('Видаліть файл install.php');
    }
} */

// error_reporting(E_ALL & ~E_NOTICE);
error_reporting(E_ALL);

if(phpversion()<7){
    exit("<b>Версія PHP має бути 7.0 або вище. (Ваша версія PHP: ".phpversion().")</b>");
}

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once './config.php';
require_once './function.php';

// enter to admin-panel
if($_POST['login'] && $_POST['password']){

    $login = trim($_POST['login']);
    $password = trim($_POST['password']);

    $sql = 'SELECT `login` FROM `users` WHERE `login` = :login && `password` = :password';
    $query = $pdo->prepare($sql);
    $query->execute(['login' => $login, 'password' => md5($password.$salt)]);
    $user = $query->fetch(PDO::FETCH_OBJ);

    $message = '';
    if($user->login == $login){
        setcookie('admin', $login, time() + 3600);
        $message = <<<HTML
        <style>
            *{padding:0;margin:0;box-sizing:border-box}
            .message{text-align:center;padding:5px}
            form{width:300px;margin:auto;padding:5px}
            form button{display:block;margin:5px;padding:5px;cursor:pointer;color:red}
        </style>
        <form method="post" class="message" name="out">
            <button>Вийти?</button>
        </form>
        <p class="message">У системі</p>
HTML;

        // redirect
        // header("Location:" . $_SERVER['PHP_SELF']);
    }
} else {
    $message = <<<HTML
    <style>
        *{padding:0;margin:0;box-sizing:border-box}
        form{width:300px;margin:auto;padding:5px}
        input{display:block;margin:5px;padding:5px;width:100%}
        button{display:block;margin:5px;padding:5px;cursor:pointer}
    </style>
    <form method="post">
        <input type="text" name="login">
        <input type="text" name="password">
        <button>Увійти</button>
    </form>
HTML;
}

// out from admin-panel
if($_POST['out']){
    setcookie('admin', $login, time() - 3600);
}

echo $message;









// end php