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
use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\AuthenticationProviderManager;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;




final class PostController extends AbstractController
{
    #[Route('/', name: 'defaultAction', methods: ['GET', 'POST'])]
    public function defaultAction(Request $request, AuthenticationUtils $authenticationUtils, EntityManagerInterface $em, PostRepository $pr)
    {
        
        $posts = $em->getRepository(Post::class)->findAll();


        if(!$this->getUser()){
            return $this->render('post/index.html.twig', array('posts' => $posts));
        }

        $post = new Post();
        $form = $this->createForm(PostFormType::class, $post);

        return $this->render('post/index.html.twig', array('postForm' => $form->createView(), 'posts' => $posts));
    }


    #[Route('/ajax/login', name: 'ajaxLogin', methods: ['POST'])]
    public function loginCheck(Request $request, UserRepository $userRepository, TokenStorageInterface $tokenStorage){ 

        $username = $request->request->get('username');
        $password = $request->request->get('password');

        $user = $userRepository->findOneBy(['username' => $username]);

        if (!$user) {
            return new JsonResponse(['success' => false]);
        }

        if (!password_verify($password, $user->getPassword())) {
            return new JsonResponse(['success' => false]);
        }

        $token = new UsernamePasswordToken($user, 'main', $user->getRoles());
        $tokenStorage->setToken($token);
        $request->getSession()->set('_security_main', serialize($token));

        return new JsonResponse(['success' => true]);
    }


    #[Route('/ajax/postList', name: 'ajaxPostList', methods: ['GET'])]
    public function PostList(Request $request, EntityManagerInterface $em){ 

        $posts = $em->getRepository(Post::class)->findAll();
        $post_table = $this->renderView('post/postTable.html.twig', ['posts' => $posts]);

        return new Response($post_table);
        
    }


    #[Route('/ajax/postForm', name: 'ajaxPostForm', methods: ['GET', 'POST'])]
    public function postForm(EntityManagerInterface $em){

        $post = new Post();
        $form = $this->createForm(PostFormType::class, $post);

        $html = $this->renderView('post/postForm.html.twig', ['postForm' => $form->createView()]);

        return new Response($html);
    }


    #[Route('/ajax/postAdd', name: 'ajaxpostAdd', methods: ['POST'])]
    public function postAdd(Request $request, EntityManagerInterface $em){ 

        $post = new Post();
        $form = $this->createForm(PostFormType::class, $post);

        $form->handleRequest($request);
        
        if (!$form->isSubmitted() || !$form->isValid()){
            return new JsonResponse(['error' => 'Form is invalid']);
        }   


        $em->persist($post);
        $em->flush();

        return new JsonResponse(['success' => 'Successfully posted!']);
        
    }



    #[Route('/view/{id}', name: 'viewAction')]
    public function viewAction(int $id, PostRepository $pr, EntityManagerInterface $em){

        $post = $em->getRepository(Post::class)->findOneBy(['id' => $id]);
        if (!$post){
            return new JsonResponse(['error' => 'No Post!']);
        }
        
        $post_detail = ['title' => $post->getTitle(), 'content' => $post->getContent(), 'created' => $post->getCreated()->format('Y-m-d H:i:s')];

        $postHtml = $this->renderView('post/postDetail.html.twig', ['postDetail' => $post_detail]);
        return new Response($postHtml);

    }


    #[Route('/delete/{id}', name: 'deleteAction')]
    public function deleteAction(int $id, PostRepository $pr, EntityManagerInterface $em){

        $post = $em->getRepository(Post::class)->findOneBy(['id' => $id]);
        if (!$post){
            return new JsonResponse(['error' => 'No Post!']);
        }

        $em->remove($post);
        $em->flush();
        return new JsonResponse(['success' => 'Post Sucesfully deleted!']);

    }

}
