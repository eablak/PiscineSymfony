<?php


namespace App\Service;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class Ex03Service extends AbstractExtension{

    public function uppercaseWords(string $content){
        return ucwords($content);
    }


    public function countNumbers(string $content){
        return preg_match_all("/[0-9]/", $content);
    }


}

?>

