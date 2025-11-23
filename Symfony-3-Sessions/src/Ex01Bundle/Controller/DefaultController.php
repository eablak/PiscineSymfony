<?php

namespace App\Ex01Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Post;



#[Route('e01')]
class DefaultController extends AbstractController{
    
    #[Route('/', name: 'e01_index')]
    public function index(EntityManagerInterface $em): Response{

        $posts = $em->getRepository(POST::class)->findBy(array() ,array('created' => 'DESC'));
        return $this->render('@Ex01/default/index.html.twig',array('posts' => $posts));
    }

}


?>