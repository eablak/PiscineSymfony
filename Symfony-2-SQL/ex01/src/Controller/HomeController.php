<?php

namespace App\Controller;

use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class HomeController extends AbstractController{

    private string $db_server;
    private string $db_user;
    private string $db_pass;
    private string $db_name;
    private $conn;

    public function __construct(string $db_server, string $db_user, string $db_pass, string $db_name){
        $this->db_server = $db_server;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_name = $db_name;
    }



    #[Route('/e00', name: 'home', methods: ['GET','POST'])]
    public function index(){
        
        return $this->render('index.html.twig');
    }


    public function create_table(): Response{

        

        return new Response("hello");
    }

}



?>