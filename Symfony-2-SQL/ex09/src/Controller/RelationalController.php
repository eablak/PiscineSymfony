<?php

namespace App\Controller;

use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use App\Entity\Forms\PersonForm;
use App\Entity\Forms\BankAccountForm;
use App\Entity\Forms\AddressForm;
use App\Entity\Person;
use App\Entity\Address;
use App\Entity\BankAccount;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



enum MaritalStatus: string{
    case Single = 'single';
    case Married = 'married';
    case Widower = 'widower';
}


class RelationalController extends AbstractController{

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


    #[Route('e09/create_person', name:'insert', methods: ['GET', 'POST'])]
    public function create_person(EntityManagerInterface $em, Request $request){


        $userform = new PersonForm();
        $form = $this->createFormBuilder($userform)
            ->add('username', TextType::class)
            ->add('name', TextType::class)
            ->add('email', EmailType::class)
            ->add('enable', CheckboxType::class)
            ->add('birthdate', DateTimeType::class)
            ->add('maritalStatus', EnumType::class, [
                'class' => MaritalStatus::class ])
            ->add('submit', SubmitType::class, array('label' => 'Submit'))
            ->getForm();

        $error_log = "";
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){

                $data = $form->getData();

                $person = new Person();
                $person->setUserName($data->getUserName());
                $person->setName($data->getName());
                $person->setEmail($data->getEmail());
                $person->setEnable($data->getEnable());
                $person->setBirthDate($data->getBirthDate());
                $person->setMaritalStatus($data->getMaritalStatus());

                $em->persist($person);
                $em->flush();
                
                return $this->redirectToRoute('insert');
            }
        }

        return $this->render('insert.html.twig', array('form' => $form->createView(), 'error_log' => $error_log));
    }


    #[Route('e09/create_bank_account', name:'bank_acc', methods: ['GET', 'POST'])]
    public function create_bank_account(EntityManagerInterface $em, Request $request){


        $qb = $em->createQueryBuilder()->select("person.id")->from(Person::class, 'person');
        $result = $qb->getQuery()->getScalarResult();
        if (!$result){
            return new Response ("You cant create bank account without person id");}

        // foreach($result as $res_id){
        //     print_r($res_id['id']);
        // }

        $choices = array_column($result, 'id', 'id');

        $bankform = new BankAccountForm();
        $form = $this->createFormBuilder($bankform)
            ->add('user_id', TextType::class)
            ->add('account_id', TextType::class)
            ->add('name', TextType::class)
            ->add('password', TextType::class)
            ->add('person', ChoiceType::class, ['choices' => $choices])
            ->add('submit', SubmitType::class, array('label' => 'Submit'))
            ->getForm();

        $error_log = "";
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){

                $data = $form->getData();

                $bankacc = new BankAccount();
                $bankacc->setUserId($data->getUserId());
                $bankacc->setAccountId($data->getAccountId());
                $bankacc->setName($data->getName());
                $bankacc->setPassword($data->getPassword());
                $personId = $data->getPerson();
                $person = $em->getRepository(Person::class)->find($personId);
                $bankacc->setPerson($person);

                try{
                    $em->persist($bankacc);
                    $em->flush();
                    return new Response("Succesfully created bank for id $personId person \n");
                }catch(UniqueConstraintViolationException $e){
                    return new Response("This person already has bank account \n");
                }
                
                return $this->redirectToRoute('bank_acc');
                   
            }
        }

        return $this->render('insert.html.twig', array('form' => $form->createView(), 'error_log' => $error_log));
    }


    #[Route('e09/create_address',  methods: ['GET', 'POST'])]
    public function create_address(EntityManagerInterface $em, Request $request){


        $qb = $em->createQueryBuilder()->select("person.id")->from(Person::class, 'person');
        $result = $qb->getQuery()->getScalarResult();
        if (!$result){
            return new Response ("You cant create address without person id");}

        $choices = array_column($result, 'id', 'id');

        $bankform = new AddressForm();
        $form = $this->createFormBuilder($bankform)
            ->add('user_id', TextType::class)
            ->add('name', TextType::class)
            ->add('address', TextType::class)
            ->add('person', ChoiceType::class, ['choices' => $choices])
            ->add('submit', SubmitType::class, array('label' => 'Submit'))
            ->getForm();

        $error_log = "";
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){

                $data = $form->getData();

                $address = new Address();
                $address->setUserId($data->getUserId());
                $address->setName($data->getName());
                $address->setAddress($data->getAddress());
                $personId = $data->getPerson();
                $person = $em->getRepository(Person::class)->find($personId);
                $address->setPerson($person);

                $em->persist($address);
                $em->flush();
                return new Response("Succesfully created address for $personId id person \n");
            }
        }

        return $this->render('insert.html.twig', array('form' => $form->createView(), 'error_log' => $error_log));
    }


    #[Route('e09/update_bank_account/{id}', methods: ['GET', 'POST'])]
    public function update_bank_account(EntityManagerInterface $em, Request $request, int $id){

        $acc = $em->getRepository(BankAccount::class)->findBy(array('id'=>$id));
        if(!$acc){
            return new Response("No Account");
        }

        $account = $em->getRepository(BankAccount::class)->findOneBy(['id'=>$id]);

        $form = $this->createFormBuilder($account)
            ->add('user_id', TextType::class)
            ->add('account_id', TextType::class)
            ->add('name', TextType::class)
            ->add('password', TextType::class)
            ->add('person', EntityType::class, ['class' => Person::class, 'choice_label' => 'id', 'choice_value' => 'id'])
            ->add('submit', SubmitType::class, array('label' => 'Submit'))
            ->getForm();


        if ($request->isMethod('POST')){
            $form->handleRequest($request);

            try{
                if($form->isSubmitted() && $form->isValid()){
                    $em->flush();
                    return new Response ("updated");}
            }catch(UniqueConstraintViolationException $e){
                return new Response("This person already has bank account \n");}
        }

        return $this->render('update.html.twig', array('form'=>$form->createView()));

    }

    
    #[Route('e09/update_address/{id}', name:'bank_acc', methods: ['GET', 'POST'])]
    public function update_address(EntityManagerInterface $em, Request $request, int $id){

        $add = $em->getRepository(Address::class)->findBy(array('id'=>$id));
        if(!$add){
            return new Response("No Addres");
        }

        $address = $em->getRepository(Address::class)->findOneBy(['id'=>$id]);

        $form = $this->createFormBuilder($address)
            ->add('user_id', TextType::class)
            ->add('name', TextType::class)
            ->add('address', TextType::class)
            ->add('person', EntityType::class, ['class' => Person::class, 'choice_label' => 'id', 'choice_value' => 'id'])
            ->add('submit', SubmitType::class, array('label' => 'Submit'))
            ->getForm();


        if ($request->isMethod('POST')){
            $form->handleRequest($request);

            try{
                if($form->isSubmitted() && $form->isValid()){
                    $em->flush();
                    return new Response ("updated");}
            }catch(UniqueConstraintViolationException $e){
                return new Response("Error $e\n");}
        }

        return $this->render('update.html.twig', array('form'=>$form->createView()));

    }


}


?>