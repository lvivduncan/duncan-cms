<?php
require_once './config.php';

if($_POST['login'] && $_POST['password'] && $_POST['email']){

    $sql = 'CREATE TABLE `users` (
            `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `login` varchar(32) NOT NULL,
            `password` varchar(32) NOT NULL,
            `email` varchar(32) NOT NULL,
            PRIMARY KEY (id)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8';

    $query = $pdo->exec($sql);

    $login = filter_var(trim($_POST['login'], FILTER_VALIDATE_STRING));
    $password = md5(filter_var(trim($_POST['password'], FILTER_VALIDATE_STRING)) . $salt);
    $email = filter_var(trim($_POST['email'], FILTER_VALIDATE_EMAIL));

    $sql = 'INSERT INTO users (login, password, email) VALUES(?, ?, ?)';
    $query = $pdo->prepare($sql);
    $query->execute([$login, $password, $email]);

    // todo: create/rewrite config.php
    // chmod('config.php', 0644);

    header("Location: ./admin.php");
}

$content = <<<HTML
    <style>
        *{padding:0;margin:0;box-sizing:border-box}
        form{width:300px;margin:auto;padding:5px}
        input{display:block;margin:5px;padding:5px;width:100%}
        button{display:block;margin:5px;padding:5px;cursor:pointer}
    </style>
    <form method="post">
        <input type="text" name="login" placeholder="login *" require>
        <input type="text" name="password" placeholder="password *" require>
        <!-- <input type="text" name="password2"> -->
        <input type="text" name="email" placeholder="email *" require>
        <button>Install!</button>
    </form>
HTML;

echo $content;

// end php