<?php

namespace App\Ex04Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Storage\MetadataBag;
use App\Ex01Bundle\Controller;


#[Route('e04')]
class DefaultController extends AbstractController{

    public function __construct(private RequestStack $requestStack,){
    }

   
    #[Route('/', name: 'e04_index')]
    public function e04_index(RequestStack $requestStack)
    {
        return $this->redirectToRoute('e01_index');
    }

}

?>