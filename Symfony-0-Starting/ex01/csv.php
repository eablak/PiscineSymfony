<?php

$file = fopen("ex01.txt","r");

if ($file){
    
    $content = fread($file, filesize("ex01.txt"));
    $pieces = explode(",", $content);

    foreach($pieces as $piece){
        $piece = trim($piece);
        echo $piece . "\n";
    }

    fclose($file);

}else{
    echo "Failed to open file\n";
}


?>