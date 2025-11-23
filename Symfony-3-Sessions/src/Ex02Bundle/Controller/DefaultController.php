<?php

namespace App\Ex02Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Repository\UserRepository;




#[Route('e02')]
#[IsGranted('ROLE_ADMIN')]
class DefaultController extends AbstractController{
    
    #[Route('/', name: 'e02_index')]
    public function index(UserRepository $ur): Response{

        $users = $ur->findAll();
        return $this->render('@Ex02/default/index.html.twig', array('users' => $users));
    }


    #[Route('/delete/{id}', name: 'user_delete')]
    public function user_delete(UserRepository $ur, int $id, EntityManagerInterface $em){
        
        $result = $ur->findBy(array('id' => $id));
        if ($result){
            $em->remove($result[0]);
            $em->flush();
            return new Response("$id user sucessfully deleted");
        }
        return new Response("User don't exsist");
    }

}


?>