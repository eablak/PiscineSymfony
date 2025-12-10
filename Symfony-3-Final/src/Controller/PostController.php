<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Form\PostFormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Post;
use App\Repository\PostRepository;


final class PostController extends AbstractController
{
    #[Route('/', name: 'defaultAction', methods: ['GET', 'POST'])]
    public function defaultAction(Request $request, AuthenticationUtils $authenticationUtils, EntityManagerInterface $em, PostRepository $pr)
    {
        
        $posts = $em->getRepository(Post::class)->findAll();


        if(!$this->getUser()){
            $error = $authenticationUtils->getLastAuthenticationError();
            $last_username = $authenticationUtils->getLastUsername();

            return $this->render('post/index.html.twig', array('login' => 'false' , 'error' => $error, 'last_username' => $last_username, 'posts' => $posts));
        }

        if($request->request->get('login_ajax') && $this->getUser()){
            $arrData = ['output' => 'Successfully logged in!'];
            return new JsonResponse($arrData);
        }
        
        
        $post = new Post();
        $form = $this->createForm(PostFormType::class, $post);

        $form->handleRequest($request);
        
        if ($request->isXmlHttpRequest() && $form->isSubmitted() && $form->isValid()){

            $em->persist($post);
            $em->flush();

            $posts = $em->getRepository(Post::class)->findAll();

            $post_table = $this->renderView('post/postTable.html.twig', ['posts' => $posts]);

            return new JsonResponse(['success' => 'Successfully posted!', 'post_table' => $post_table]);
        }   
        if ($request->isXmlHttpRequest() && $form->isSubmitted() && !$form->isValid()){
            return new JsonResponse(['error' => 'Invalid Post!']);
        }

        return $this->render('post/index.html.twig', array('login' => 'true','postForm' => $form->createView(), 'posts' => $posts));
    }


    #[Route('/login_check', name: 'app_login_check', methods: ['POST'])]
    public function loginCheck(){ 
    }


    #[Route('/view/{id}', name: 'viewAction')]
    public function viewAction(int $id, PostRepository $pr, EntityManagerInterface $em){

        $post = $em->getRepository(Post::class)->findOneBy(['id' => $id]);
        if (!$post){
            return new JsonResponse(['response' => 'No Post!']);
        }
        
        $post_detail = ['title' => $post->getTitle(), 'content' => $post->getContent(), 'created' => $post->getCreated()->format('Y-m-d H:i:s')];
        return new JsonResponse(['response' => $post_detail]);

    }


    #[Route('/delete/{id}', name: 'deleteAction')]
    public function deleteAction(int $id, PostRepository $pr, EntityManagerInterface $em){

        $post = $em->getRepository(Post::class)->findOneBy(['id' => $id]);
        if (!$post){
            return new JsonResponse(['response' => 'No Post!']);
        }

        $em->remove($post);
        $em->flush();
        return new JsonResponse(['response' => 'deleted!']);

    }

}
