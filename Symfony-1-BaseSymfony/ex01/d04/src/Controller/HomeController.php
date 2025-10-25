<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController{

    #[Route('/e01/firstpage', name: 'home', methods: ['GET'])]
    public function index(): Response{
        return $this->render("base.html.twig");
    }

}