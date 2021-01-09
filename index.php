<?php
    // error_reporting(E_ALL & ~E_NOTICE);
    error_reporting(E_ALL);
    require_once './config.php';
    require_once './function.php';
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOC</title>
    <link rel="stylesheet" href="vendor/style.css">
</head>
<body>
    
    <header>
        <div class="container">
            header

<?php



?>


        </div>
    </header>
    <div class="content">
        <main>

        <?php

            if(!isset($_GET['page'])){
                include './block/main.php';
            } else {
                switch ($_GET['page']) {
                    case 'main':
                        include './block/main.php';
                        break;
                    case 'about':
                        include './block/about.php';
                        break;
                    case 'info':
                        include './block/info.php';
                        break;
                    
                    default:
                        include './block/404.php';
                        break;
                }
            }
        ?>

        </main>
        <aside>
            <nav>
                <ul>
                    <li><a href="index.php?page=main">1 index</a></li>
                    <li><a href="index.php?page=about">2 about</a></li>
                    <li><a href="">3 news</a></li>
                    <li><a href="index.php?page=info">4 info</a></li>
                    <li><a href="">5 contacts</a></li>
                </ul>
            </nav>
            <hr>
            <form method="post">
                <input type="text" name="text">
                <button type="submit" name="send">send!</button>
            </form>
            <hr>
            <?php
                if(isset($_POST['send'])){
                    $text = $_POST['text'] . PHP_EOL;
                    $file = fopen('data/data.txt', 'a');
                    if(fwrite($file, $text)){
                        echo 'Content added!';
                    } else {
                        echo 'Content not added!!!';
                    }
                    fclose($file);
                }
            ?>
        </aside>
    </div>

    <footer>
        <div class="container">
            footer
        </div>
    </footer>

</body>
</html>