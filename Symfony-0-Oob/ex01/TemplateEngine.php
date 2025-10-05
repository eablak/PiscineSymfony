<?php

class TemplateEngine{

    function createFile($fileName, $text){
        
        $file = fopen($fileName, "w");

        $html = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>POESIA</title>
        </head>
        <body>
            ' . $text . '
        </body>
        </html>';

        fwrite($file, $html);
        fclose($file);
    }


}


?>