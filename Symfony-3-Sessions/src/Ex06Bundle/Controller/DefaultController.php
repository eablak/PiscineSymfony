<?php

namespace App\Ex06Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Storage\MetadataBag;
use App\Ex06Bundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Form\PostForm;
use App\Entity\Post;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


#[Route('e06')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
class DefaultController extends AbstractController{

    #[Route('/edit_post/{post_id}', name: 'edit_post')]
    public function e06_index(int $post_id, Request $request, EntityManagerInterface $em)
    {

        $post = $em->getRepository(Post::class)->findOneBy(['id'=>$post_id]);

        if (!$post)
            return new Response("No Post");

        $current_user = $this->getUser();
        if (!($current_user == $post->getAuthor() || $current_user->getReputation() >= 9 || $current_user->getRoles()[0] == "ROLE_ADMIN"))
            return new Response ("You dont have a accessibility to edit this post");


        $form = $this->createFormBuilder($post)
            ->add('title', TextType::class)
            ->add('content', TextareaType::class)
            ->add('update', SubmitType::class, array('label' => 'Update'))->getForm();
        
        if ($request->isMethod('POST')){
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()){

                $post->setLastEditedTime(new \DateTime());
                $post->setLastEditedUser($this->getUser());
                $em->flush();
                return new Response ("Post Sucessfully Updated!");

            }else{
                return new Response ("Cannot Updated");
            }
        }

        return $this->render('@Ex06/default/index.html.twig', array('form'=>$form));

    }

}

?>