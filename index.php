<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOC</title>
    <link rel="stylesheet" href="vendor/style.css">
</head>
<body>
    
    <header class="block">
        <div class="container">
            header
        </div>
    </header>
    <div class="content block">
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
                
                default:
                    include './block/404.php';
                    break;
            }
        }
    ?>

    </main>
    <aside>
        <?php
            include './block/aside.php';
        ?>
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


    <footer class="block">
        <div class="container">
            footer
        </div>
    </footer>


</body>
</html>