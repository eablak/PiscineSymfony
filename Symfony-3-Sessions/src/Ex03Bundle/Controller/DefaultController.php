<?php

namespace App\Ex03Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Form\PostForm;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Post;



#[Route('e03')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
class DefaultController extends AbstractController{
    
    #[Route('/', name: 'e03_index')]
    public function index(Request $request, EntityManagerInterface $em): Response{

        if (!($this->getUser()->GetReputation() >= 0 || $this->getUser()->getRoles()[0] == "ROLE_ADMIN")){
            return new Response ("You dont have a accessibility to create this post");
        }


        $postform = new PostForm();
        $form = $this->createFormBuilder($postform)->add('title', TextType::class)->add('content', TextareaType::class)->add('submit', SubmitType::class, array('label' => 'Submit'))->getForm();

        $error_log = "";
        if ($request->isMethod('POST')){

            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $data = $form->getData();

                $post = new Post();
                $post->setTitle($data->getTitle());
                $post->setContent($data->getContent());
                $post->setAuthor($this->getUser());
                $post->setCreated(new \DateTime());

                $em->persist($post);
                $em->flush();

                return new Response("Sucessfully Posted");
            }
        }

        return $this->render('@Ex03/default/index.html.twig', array('form' => $form, 'error_log' => $error_log));
    }


    #[Route('/post_detail/{id}', name: 'post_detail')]
    public function post_detail(EntityManagerInterface $em, Request $request, int $id){

        $post = $em->getRepository(POST::class)->findOneBy(['id'=>$id]);

        if (!$post){
            return new Response("Invalid Post Id");
        }

        return $this->render('@Ex03/default/detail.html.twig', array('post' => $post));
    }

}


?>