<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Post;
use App\Entity\Vote;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private $userPasswordHasherInterface;

    public function __construct (UserPasswordHasherInterface $userPasswordHasherInterface) 
    {
        $this->passwordHasher = $userPasswordHasherInterface;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $user1 = new User();
        $user1->setUserName("red");
        $user1->setPassword($this->passwordHasher->hashPassword($user1, "redpassword"));
        $manager->persist($user1);

        $user2 = new User();
        $user2->setUserName("green");
        $user2->setPassword($this->passwordHasher->hashPassword($user2, "greenpassword"));
        $manager->persist($user2);

        $user3 = new User();
        $user3->setUserName("blue");
        $user3->setPassword($this->passwordHasher->hashPassword($user3, "bluepassword"));
        $manager->persist($user3);

        $user4 = new User();
        $user4->setUserName("black");
        $user4->setPassword($this->passwordHasher->hashPassword($user4, "blackpassword"));
        $manager->persist($user4);

        $user5 = new User();
        $user5->setUserName("white");
        $user5->setPassword($this->passwordHasher->hashPassword($user5, "whitepassword"));
        $manager->persist($user5);

        $user6 = new User();
        $user6->setUserName("admin");
        $user6->setRoles(["ROLE_ADMIN"]);
        $user6->setPassword($this->passwordHasher->hashPassword($user6, "adminpassword"));
        $manager->persist($user6);




        $post1 = new Post();
        $post1->setTitle("Title1");
        $post1->setContent("Content1");
        $post1->setCreated(new \DateTime);
        $post1->setAuthor($user1);
        $manager->persist($post1);

        $post2 = new Post();
        $post2->setTitle("Title2");
        $post2->setContent("Content2");
        $post2->setCreated(new \DateTime);
        $post2->setAuthor($user2);
        $manager->persist($post2);

        $post_2 = new Post();
        $post_2->setTitle("222");
        $post_2->setContent("Another2");
        $post_2->setCreated(new \DateTime);
        $post_2->setAuthor($user2);
        $manager->persist($post_2);

        $post3 = new Post();
        $post3->setTitle("Title3");
        $post3->setContent("Content3");
        $post3->setCreated(new \DateTime);
        $post3->setAuthor($user3);
        $manager->persist($post3);

        $post4 = new Post();
        $post4->setTitle("Title4");
        $post4->setContent("Content4");
        $post4->setCreated(new \DateTime);
        $post4->setAuthor($user4);
        $manager->persist($post4);

        $post5 = new Post();
        $post5->setTitle("Title5");
        $post5->setContent("Content5");
        $post5->setCreated(new \DateTime);
        $post5->setAuthor($user5);
        $manager->persist($post5);

        $post6 = new Post();
        $post6->setTitle("Title6");
        $post6->setContent("Content6");
        $post6->setCreated(new \DateTime);
        $post6->setAuthor($user5);
        $manager->persist($post6);




        $vote1 = new Vote();
        $vote1->setValue(1);
        $vote1->setUser($user3);
        $vote1->setPost($post5);
        $manager->persist($vote1);

        $vote2 = new Vote();
        $vote2->setValue(1);
        $vote2->setUser($user1);
        $vote2->setPost($post2);
        $manager->persist($vote2);

        $vote3 = new Vote();
        $vote3->setValue(1);
        $vote3->setUser($user1);
        $vote3->setPost($post_2);
        $manager->persist($vote3);

        $vote4 = new Vote();
        $vote4->setValue(1);
        $vote4->setUser($user2);
        $vote4->setPost($post2);
        $manager->persist($vote4);

        $vote5 = new Vote();
        $vote5->setValue(1);
        $vote5->setUser($user2);
        $vote5->setPost($post_2);
        $manager->persist($vote5);

        $vote6 = new Vote();
        $vote6->setValue(1);
        $vote6->setUser($user3);
        $vote6->setPost($post_2);
        $manager->persist($vote6);

        $vote = new Vote();
        $vote->setValue(1);
        $vote->setUser($user3);
        $vote->setPost($post_2);
        $manager->persist($vote);

        $vote7 = new Vote();
        $vote7->setValue(1);
        $vote7->setUser($user6);
        $vote7->setPost($post2);
        $manager->persist($vote7);

        $vote8 = new Vote();
        $vote8->setValue(1);
        $vote8->setUser($user4);
        $vote8->setPost($post2);
        $manager->persist($vote8);

        $vote9 = new Vote();
        $vote9->setValue(1);
        $vote9->setUser($user4);
        $vote9->setPost($post_2);
        $manager->persist($vote9);

        $vote10 = new Vote();
        $vote10->setValue(1);
        $vote10->setUser($user5);
        $vote10->setPost($post5);
        $manager->persist($vote10);

        $vote11 = new Vote();
        $vote11->setValue(-1);
        $vote11->setUser($user1);
        $vote11->setPost($post5);
        $manager->persist($vote11);

        $vote12 = new Vote();
        $vote12->setValue(1);
        $vote12->setUser($user2);
        $vote12->setPost($post5);
        $manager->persist($vote12);

        $vote13 = new Vote();
        $vote13->setValue(1);
        $vote13->setUser($user3);
        $vote13->setPost($post5);
        $manager->persist($vote13);

        $vote14 = new Vote();
        $vote14->setValue(1);
        $vote14->setUser($user4);
        $vote14->setPost($post5);
        $manager->persist($vote14);

        $vote15 = new Vote();
        $vote15->setValue(-1);
        $vote15->setUser($user5);
        $vote15->setPost($post6);
        $manager->persist($vote15);

        $vote16 = new Vote();
        $vote16->setValue(1);
        $vote16->setUser($user1);
        $vote16->setPost($post6);
        $manager->persist($vote16);

        $vote17 = new Vote();
        $vote17->setValue(1);
        $vote17->setUser($user2);
        $vote17->setPost($post6);
        $manager->persist($vote17);

        $vote17 = new Vote();
        $vote17->setValue(1);
        $vote17->setUser($user3);
        $vote17->setPost($post6);
        $manager->persist($vote17);

        $vote18 = new Vote();
        $vote18->setValue(1);
        $vote18->setUser($user4);
        $vote18->setPost($post6);
        $manager->persist($vote18);

        $vote19 = new Vote();
        $vote19->setValue(-1);
        $vote19->setUser($user4);
        $vote19->setPost($post6);
        $manager->persist($vote19);

        $vote20 = new Vote();
        $vote20->setValue(1);
        $vote20->setUser($user4);
        $vote20->setPost($post3);
        $manager->persist($vote20);

        $vote21 = new Vote();
        $vote21->setValue(1);
        $vote21->setUser($user1);
        $vote21->setPost($post3);
        $manager->persist($vote21);

        $vote22 = new Vote();
        $vote22->setValue(-1);
        $vote22->setUser($user2);
        $vote22->setPost($post3);
        $manager->persist($vote22);

        $vote24 = new Vote();
        $vote24->setValue(1);
        $vote24->setUser($user6);
        $vote24->setPost($post3);
        $manager->persist($vote24);

        $vote25 = new Vote();
        $vote25->setValue(1);
        $vote25->setUser($user5);
        $vote25->setPost($post3);
        $manager->persist($vote25);

        $manager->flush();
    }
}
