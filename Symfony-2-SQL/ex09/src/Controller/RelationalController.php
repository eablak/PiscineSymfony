<?php

namespace App\Controller;

use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use App\Entity\UserForm;
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


    #[Route('e09/create_person', methods: ['GET', 'POST'])]
    public function create_person(EntityManagerInterface $em){
        
        $person = new Person();
        $person->setUsername("user1");
        $person->setName("esra");
        $person->setEmail("esra@gmail.com");
        $person->setEnable(true);
        $person->setMaritalStatus("single");

        $em->persist($person);
        $em->flush();
        return new Response("person created sucessfully");
    }

    #[Route('/e09/add_bank_account/{id}')]
    public function addBankAccount(int $id, EntityManagerInterface $em): Response
    {
        $person = $em->getRepository(Person::class)->find($id);
        if (!$person) {
            return new Response("Person not found.");
        }

        $bank = new BankAccount();
        $bank->setAccountId("4444");
        $bank->setUserId("9");
        $bank->setName("Vakıf");
        $bank->setPassword("1234");
        $bank->setPerson($person);

        $em->persist($bank);
        $em->flush();

        return new Response("Bank account created for person id: " . $id);
    }

    #[Route('/e09/add_address/{id}')]
    public function addAddress(int $id, EntityManagerInterface $em): Response
    {
        $person = $em->getRepository(Person::class)->find($id);
        if (!$person) {
            return new Response("Person not found.");
        }

        $address = new Address();
        $address->setName("Ev");
        $address->setUserId("9");
        $address->setAddress("Istanbul");
        $address->setPerson($person);

        $em->persist($address);
        $em->flush();

        return new Response("Address added to person id: " . $id);
    }


   

}


?>