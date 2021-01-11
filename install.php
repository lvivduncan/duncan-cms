<?php
require_once './config.php';

$sql = 'CREATE TABLE `users` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `login` varchar(32) NOT NULL,
        `password` varchar(32) NOT NULL,
        `email` varchar(32) NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8';

$query = $pdo->exec($sql);

// // todo: чекаємо чи є така таблиця

$sql = 'INSERT INTO users (login, password, email) VALUES(?, ?, ?)';
$query = $pdo->prepare($sql);
$query->execute(['admin', '8223fe8dc0533c6ebbb717e7fda2833c', 'duncan@site.com']);

header("Location: ./admin.php");

// end php