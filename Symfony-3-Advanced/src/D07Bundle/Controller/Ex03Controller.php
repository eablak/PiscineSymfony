<?php

namespace App\D07Bundle\Controller;

use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class Ex03Controller extends AbstractController{

    #[Route('/ex03', name: 'ex03_index')]
    public function ex03_index(TranslatorInterface $translator){

        $message = $translator->trans('ex03.content');

        return $this->render('@D07/ex03.html.twig', array('message' => $message));
    }

}


?>