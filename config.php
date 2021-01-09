<?php
$user = 'admin';
$password = 'JMpV23DG9won';
$db = 'duncan';
$host = 'localhost';

$dsn = 'mysql:host='.$host.';dbname='.$db;

$pdo = new PDO($dsn, $user, $password);

// salt for user password
$salt = 'abc';
