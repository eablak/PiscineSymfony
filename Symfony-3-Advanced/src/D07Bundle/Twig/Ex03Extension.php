<?php

namespace App\D07Bundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use D07Bundle\Twig;
use App\Service\Ex03Service;

class Ex03Extension extends AbstractExtension{

    private $ex03service;

    public function __construct(Ex03Service $ex03service){
        $this->ex03service = $ex03service;
    }

    public function getFilters(){
        return [
            new TwigFilter('uppercaseWords', [$this->ex03service, 'uppercaseWords']),
        ];
    }

    public function getFunctions(){
        return [
            new TwigFunction('countNumbers', [$this->ex03service, 'countNumbers'])
        ];
    }


}

?>