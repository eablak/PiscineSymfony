<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController{

    private int $number_of_colors;

    public function __construct(int $number_of_colors){
        $this->number_of_colors = $number_of_colors;
    }


    #[Route('/e03', name: 'home', methods: ['GET'])]
    public function index(){

        $color_shades = [];

        for ($x = 0; $x < $this->number_of_colors; $x++) {
            $value = $x * (255 / ($this->number_of_colors - 1));
            array_push($color_shades, sprintf("%02X", $value));
        }

        return $this->render('base.html.twig', array(
            'colors' => $color_shades,
        ));
    }

}