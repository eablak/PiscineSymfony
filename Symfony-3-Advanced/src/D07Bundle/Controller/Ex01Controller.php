<?php

namespace App\D07Bundle\Controller;

use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class Ex01Controller extends AbstractController{

    #[Route('ex01', name: 'ex01_action')]
    public function ex01Action(){

        $number = $this->getParameter('d07.number');
        return new Response((string)$number);

    }

}


?>