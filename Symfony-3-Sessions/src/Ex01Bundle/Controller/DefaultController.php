<?php

namespace App\Ex01Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('e01')]
class DefaultController extends AbstractController{
    
    #[Route('/', name: 'e01_index')]
    public function index(): Response{

        if ($this->getUser()){
            $username = $this->getUser()->getUsername();
        }

        return $this->render('@Ex01/default/index.html.twig');
    }

}


?>