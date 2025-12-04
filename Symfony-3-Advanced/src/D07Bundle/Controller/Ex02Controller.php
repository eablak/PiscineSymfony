<?php

namespace App\D07Bundle\Controller;

use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class Ex02Controller extends AbstractController{

    #[Route('/{_locale}/ex02/{count}', name: 'translationsAction', requirements: ['_locale' => 'en|fr', 'count' => '[0-9]'])]
    public function translationsAction(string $_locale, int $count=0){

        $number = $this->getParameter('d07.number');

        return $this->render('@D07/ex02.html.twig', array('number' => $number, 'count' => $count));
    }

}


?>