<h1>Info</h1>
<p>
<?php

    $filename = 'data/data.txt';
    $handle = fopen($filename, "r");
    $contents = fread($handle, filesize($filename));

        $contents = str_replace("\n" , '<br>', $contents);
        echo $contents;

    fclose($handle);

?>
</p>