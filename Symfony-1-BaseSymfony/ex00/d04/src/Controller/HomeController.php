<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class HomeController{

    #[Route('/ex00/firstpage', name: 'home', methods: ['GET'])]
    public function index(): Response{
        return new Response('Hello world!');
    }

}