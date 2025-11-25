<?php

namespace App\Ex04Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Storage\MetadataBag;


class DefaultController extends AbstractController{

    public function __construct(private RequestStack $requestStack,){
    }


    public function e04_index(RequestStack $requestStack)
    {
        return $session->get('an_name');
    }

}

?>