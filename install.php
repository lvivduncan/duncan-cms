<?php
if(
        $_POST['user_name'] &&
        $_POST['data_base'] &&
        $_POST['user_password'] &&
        $_POST['host_name'] &&
        $_POST['login'] && 
        $_POST['password'] && 
        $_POST['email']
    ){

    // create config.php and write data
    $user_name = filter_var(trim($_POST['user_name'], FILTER_SANITIZE_STRING));
    $data_base = filter_var(trim($_POST['data_base'], FILTER_SANITIZE_STRING));
    $user_password = filter_var(trim($_POST['user_password'], FILTER_SANITIZE_STRING));
    $host_name = filter_var(trim($_POST['host_name'], FILTER_SANITIZE_STRING));
    $salt = filter_var(trim($_POST['salt'], FILTER_SANITIZE_STRING));
    
    $pdo = new PDO("mysql:host=$host_name;dbname=$data_base", $user_name, $user_password);

    $sql = 'CREATE TABLE `users` (
            `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `login` varchar(32) NOT NULL,
            `password` varchar(32) NOT NULL,
            `email` varchar(32) NOT NULL,
            PRIMARY KEY (id)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8';

    $query = $pdo->exec($sql);

    $login = filter_var(trim($_POST['login'], FILTER_SANITIZE_STRING));
    $password = md5(filter_var(trim($_POST['password'], FILTER_SANITIZE_STRING)) . $salt);
    $email = filter_var(trim($_POST['email'], FILTER_VALIDATE_EMAIL));

    $sql = 'INSERT INTO users (login, password, email) VALUES(?, ?, ?)';
    $query = $pdo->prepare($sql);
    $query->execute([$login, $password, $email]);

    // створив файл конфігурації
    touch('config.php');
    
    // записав туди дані
    $data = <<<HTML
<?php
\$user = '$user_name';
\$password = '$user_password';
\$db = '$data_base';
\$host = '$host_name';

\$dsn = 'mysql:host='.\$host.';dbname='.\$db;
\$pdo = new PDO(\$dsn, \$user, \$password);

\$salt = '$salt';
HTML;

    // права на файл конфігурації
    chmod('config.php', 0644);

    if(!file_put_contents('config.php', $data)){
        die('Не вдалося створити чи створити та записати файл config.php');
    }

    header("Location: ./admin.php");
}

$content = <<<HTML
    <style>
        *{padding:0;margin:0;box-sizing:border-box}
        form{width:300px;margin:auto;padding:5px}
        input{display:block;margin:5px 0;padding:5px;width:100%}
        button{display:block;margin:5px 0;padding:5px;cursor:pointer}
        hr{margin:20px 0}
    </style>
    <form method="post">
        <input type="text" name="user_name" placeholder="user_name *" require>
        <input type="text" name="data_base" placeholder="data_base *" require>
        <input type="text" name="user_password" placeholder="user_password *" require>
        <input type="text" name="host_name" placeholder="host_name *" value="localhost" require>
        <input type="text" name="salt" placeholder="salt *" value="abc012" require>
        <hr>
        <input type="text" name="login" placeholder="login *" require>
        <input type="text" name="password" placeholder="password *" require>
        <!-- <input type="text" name="password2"> -->
        <input type="text" name="email" placeholder="email *" require>
        <button>Install!</button>
    </form>
HTML;

echo $content;

// end php