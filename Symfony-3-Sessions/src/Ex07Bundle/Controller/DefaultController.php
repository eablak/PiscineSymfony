<?php

namespace App\Ex07Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Storage\MetadataBag;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Ex01Bundle\Controller;



#[Route('e07')]
class DefaultController extends AbstractController{

    #[Route('/', name: 'ex07_index')]
    public function ex07_index(){

        return $this->redirectToRoute('e01_index');

    }

}

?>