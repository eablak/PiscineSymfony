<?php

namespace App\Ex01Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Post;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Repository\UserRepository;
use App\Repository\PostRepository;
use App\Repository\VoteRepository;
use App\Entity\Vote;



#[Route('e01')]
class DefaultController extends AbstractController{
    
    #[Route('/', name: 'e01_index')]
    public function index(EntityManagerInterface $em, RequestStack $requestStack): Response{


        $session = $requestStack->getSession();
        $anonymous_names = ["Dog","Cow","Horse","Donkey","Tiger","Panther"];
        $current = time();

        if(!$session->has('an_name')){
            $name = $anonymous_names[array_rand($anonymous_names)];
            $session->set('an_name', $name);
        }

        $name = $session->get('an_name');

        if (!$session->has('last_request_time')) {
            $session->set('last_request_time', $current);
        }

        $last = $session->get('last_request_time');
        $secondsSinceLast = $current - $last;
        $session->set('last_request_time', $current);


        $posts = $em->getRepository(POST::class)->findBy(array() ,array('created' => 'DESC'));

        $this->amount_vote($posts);
        
        return $this->render('@Ex01/default/index.html.twig',array('posts' => $posts, 'an_name' => $name, 'seconds' => $secondsSinceLast));
    }


    public function amount_vote(array $posts){

        foreach ($posts as $post){
            echo($post->getVotes()->count());
        }

    }

}


?>