<?php

namespace App\Controller;

use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use App\Entity\UserForm;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class HomeController extends AbstractController{

    private string $db_server;
    private string $db_user;
    private string $db_pass;
    private string $db_name;
    private $conn;

    public function __construct(string $db_server, string $db_user, string $db_pass, string $db_name){
        $this->db_server = $db_server;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_name = $db_name;
    }



    #[Route('/e09/create', methods: ['GET','POST'])]
    public function create(){
        
        return $this->render('create.html.twig');
    }


    public function create_table(EntityManagerInterface $em){
        
        try{
            $metadata = $em->getClassMetadata(USER::class);
            $schemaTool = new SchemaTool($em);
            
            $schemaTool->updateSchema([$metadata], true);
            return new Response("Table sucessfully created");
        }catch(Exception $e){
            return new Response('Error creating table: ', $e->getMessage());
        }
    }


    #[Route('e09/insert', name:'home', methods: ['GET', 'POST'])]
    public function insert(Request $request, EntityManagerInterface $em){

        $userform = new UserForm();
        $form = $this->createFormBuilder($userform)
            ->add('username', TextType::class)
            ->add('name', TextType::class)
            ->add('email', EmailType::class)
            ->add('enable', CheckboxType::class)
            ->add('birthdate', DateTimeType::class)
            ->add('address', TextareaType::class)
            ->add('submit', SubmitType::class, array('label' => 'Submit'))
            ->getForm();

        $error_log = "";
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){

                $data = $form->getData();

                $check_username = $em->getRepository(User::class)->findOneBy(['username' => $data->getUsername()]);
                $check_email = $em->getRepository(User::class)->findOneBy(['email' => $data->getEmail()]);

                if ($check_username || $check_email){
                    $error_log = "Username or Email already taken";
                }else{
                    $user = new User();
                    $user->setUserName($data->getUserName());
                    $user->setName($data->getName());
                    $user->setEmail($data->getEmail());
                    $user->setEnable($data->getEnable());
                    $user->setBirthDate($data->getBirthDate());
                    $user->setAddress($data->getAddress());
    
                    $em->persist($user);
                    $em->flush();
                    
                    return $this->redirectToRoute('home');
                }
                   
            }
        }


        return $this->render('insert.html.twig', array('form' => $form->createView(), 'error_log' => $error_log));
    }


    #[Route('e09/read', methods: ['GET'])]
    public function read(EntityManagerInterface $em){

        $results = $em->getRepository(USER::class)->findAll();
        return $this->render('read.html.twig', array('results' => $results));
    }

    #[Route('e09/delete/{id}', methods: ['GET','POST'])]
    public function delete(int $id, EntityManagerInterface $em){

        $result = $em->getRepository(User::class)->findBy(array('id'=>$id));
        if ($result){

            $single_user = $em->getRepository(User::class)->findOneBy(['id'=>$id]);
            $em->remove($single_user);
            $em->flush();
            return new Response ("$id id user deleted");
        }else
            return new Response ("user not exist");

    }


    #[Route('e09/update/{id}', methods: ['GET', 'POST'])]
    public function update(int $id, EntityManagerInterface $em, Request $request){

        $result = $em->getRepository(User::class)->findBy(array('id'=>$id));
        if ($result){

            $single_user = $em->getRepository(User::class)->findOneBy(['id'=>$id]);

            $form = $this->createFormBuilder($single_user)
                ->add('username', TextType::class)
                ->add('name', TextType::class)
                ->add('email', EmailType::class)
                ->add('enable', CheckboxType::class)
                ->add('birthdate', DateTimeType::class)
                ->add('address', TextareaType::class)
                ->add('submit', SubmitType::class, array('label' => 'Update'))
                ->getForm();


            if ($request->isMethod('POST')){
                $form->handleRequest($request);

                if($form->isSubmitted() && $form->isValid()){
                    $em->flush();
                    return new Response ("updated");
                }else{
                    return new Response ("cannot updated");
                }
            }

            return $this->render('update.html.twig', array('form'=>$form->createView()));
        }else
            return new Response ("no user exist");

    }

}



?>