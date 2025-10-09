<?php

include "Elem.php";

class TemplateEngine{

    public $elem; 

    function __construct(Elem $elem){
        $this->elem = $elem;
    }

    function createFile($fileName){
        
        $html_content = $this->elem->getHTML();
        file_put_contents($fileName, $html_content);
    }

}


?>