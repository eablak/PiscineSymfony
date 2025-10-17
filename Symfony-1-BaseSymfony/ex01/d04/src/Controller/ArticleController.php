<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ArticleController extends AbstractController{

    #[Route('/e01', name: 'main_page', methods: ['GET'])]
    public function Base(): Response{
        return $this->render("articles.html.twig");  
    }

    #[Route('/e01/{article}', name: 'articles', methods: ['GET'])]
    public function index($article): Response{
        $Articles = ['creativity', 'motivation', 'productivity'];

        if (in_array($article, $Articles)){
            return $this->render("articles/{$article}.html.twig");
        }else{
            return $this->render("articles.html.twig");
        }
    }

}