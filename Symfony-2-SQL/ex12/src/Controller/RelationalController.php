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
use App\Entity\Forms;
use App\Enum\MaritalStatus;


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

        try{
            $this->conn = mysqli_connect($this->db_server, $this->db_user, $this->db_pass, $this->db_name);
        }catch(mysqli_sql_exception){
            echo "Could not connect \n";
        }
    }


    #[Route('e12/create_person', name:'insert', methods: ['GET', 'POST'])]
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


    #[Route('e12/create_bank_account', name:'bank_acc', methods: ['GET', 'POST'])]
    public function create_bank_account(EntityManagerInterface $em, Request $request){


        $qb = $em->createQueryBuilder()->select("person.id")->from(Person::class, 'person');
        $result = $qb->getQuery()->getScalarResult();
        if (!$result){
            return new Response ("You cant create bank account without person id");}


        $choices = array_column($result, 'id', 'id');

        $bankform = new BankAccountForm();
        $form = $this->createFormBuilder($bankform)
            ->add('user_id', TextType::class)
            ->add('account_id', TextType::class)
            ->add('bank_name', TextType::class)
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
                $bankacc->setBankName($data->getBankName());
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


    #[Route('e12/tables_data', methods: ['GET', 'POST'])]
    public function tables_data(EntityManagerInterface $em, Request $request){


        $qb = $em->createQueryBuilder();
        $qb->select('p','b')->from(Person::class, 'p')->leftJoin('p.bankAccount', 'b');

        $column = $request->query->get('column');
        $value = $request->query->get('value');
        $order = $request->query->get('order');

        if ($column && strpos($column, '.') !== false){
            $table = substr($column, 0, strpos($column, '.'));
            $column = substr($column, strpos($column, '.') +1);
            if ($table === 'bank_account'){
                $table = 'b';
            }elseif ($table === 'person'){
                $table = 'p';}
        }

        if ($column && $value) {
            $qb->andWhere("$table.$column LIKE :value")
            ->setParameter('value', $value);
        }elseif ($column && $order) {
            $qb->orderBy("$table.$column", $order);
        }

        $result = $qb->getQuery()->getResult();

        return $this->render('read.html.twig', array('results' => $result));
    }



}


?>