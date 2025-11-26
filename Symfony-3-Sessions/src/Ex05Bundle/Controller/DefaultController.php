<?php

namespace App\Ex05Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\PostRepository;
use App\Repository\VoteRepository;
use App\Entity\Vote;


#[Route('e05')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
class DefaultController extends AbstractController{
    
    #[Route('/', name: 'e05_index')]
    public function index(UserRepository $ur, PostRepository $pr, VoteRepository $vr): Response{

        $posts = $pr->findAll();
        $current_user = $this->getUser();

        return $this->render('@Ex05/default/index.html.twig', array('posts' => $posts, 'user' => $current_user));
    }


    #[Route('/handle_vote/{user_id}/{post_id}/{vote}', name: 'handle_vote')]
    public function handle_vote(int $user_id, int $post_id, int $vote, EntityManagerInterface $em, VoteRepository $vr, PostRepository $pr){
        

        $votes = $vr->findBy(array('user' => $user_id, 'post' => $post_id));

        if ($votes)
            return new Response("You can't vote again");
        
        $post = $pr->find($post_id);

        $vote_entity = new Vote();
        $vote_entity->setUser($this->getUser());
        $vote_entity->setPost($post);
        $vote_entity->setValue($vote);

        $em->persist($vote_entity);
        $em->flush();

        return new Response("Successfully voted!");
    }


}


?>