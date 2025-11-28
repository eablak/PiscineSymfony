<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\UserForm;
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

        mysqli_report(MYSQLI_REPORT_OFF);

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


    #[Route('e06/create', methods: ['GET','POST'])]
    public function create(){
        return $this->render('create.html.twig');
    }


    public function create_table(): Response{

        $sql = "
            CREATE TABLE IF NOT EXISTS users06 (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username varchar(50) UNIQUE,
                name varchar(255),
                email varchar(255) UNIQUE,
                enable BOOLEAN,
                birthdate DATETIME,
                address LONGTEXT
            )";

        $conn_info = "";
        if ($this->conn->query($sql) === TRUE){
            $conn_info = "Table created successfully";
        }else{
            $conn_info = "Error creating table: " . $this->conn->error;
        }
        return new Response($conn_info);
    }


    #[Route('e06/insert', name:'home', methods: ['GET', 'POST'])]
    public function insert(Request $request){

        $userForm = new UserForm();
        $form = $this->createFormBuilder($userForm)
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

                $username = $data->getUserName();
                $name = $data->getName();
                $email = $data->getEmail();
                $enable = $data->getEnable();
                $birthdate = $data->getBirthDate();
                $birthdate = $birthdate->format('Y-m-d H:i:s');
                $address = $data->getAddress();
                
                
                $sql = "INSERT INTO 
                users06 (username, name, email, enable, birthdate, address)
                VALUES ('$username', '$name', '$email', '$enable', '$birthdate', '$address')";

                
                if ($this->conn->query($sql) === TRUE){
                    error_log("Data insert successfully \n");
                    return $this->redirectToRoute('home');
                }else{
                    $error_log = "Error: " . $this->conn->error;
                }

            }
        }
        return $this->render('insert.html.twig', array('form' => $form->createView(), 'error_log' => $error_log));
    }


    #[Route('e06/read', methods: ['GET'])]
    public function read(){

        $sql = "SELECT * FROM users06";
        $results = $this->conn->query($sql);

        return $this->render('read.html.twig', array('results' => $results));
    }

    #[Route('e06/delete/{id}', methods: ['GET', 'POST'])]
    public function delete(int $id){

        $sql = "SELECT * FROM users06 WHERE id=$id";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0){
            $delete_sql = "DELETE FROM users06 WHERE id=$id";
            $delete_result = $this->conn->query($delete_sql);
            if ($delete_result)
                return new Response("$id id user succesfully deleted");
            else
                return new Response("$id cant delete");
        }
        else
            return new Response("no user");
    }

    #[Route('e06/update/{id}', name:'update', methods: ['GET', 'POST'])]
    public function update(int $id, Request $request){

        $sql = "SELECT * FROM users06 WHERE id=$id";
        $result = $this->conn->query($sql);
        $log = "";

        if ($result->num_rows > 0){
            
            $row = mysqli_fetch_assoc($result);

            $userForm = new UserForm();

            $userForm->setUserName($row['username']);
            $userForm->setName($row['name']);
            $userForm->setEmail($row['email']);
            $userForm->setEnable((bool)$row['enable']);
            $userForm->setBirthDate(new \Datetime($row['birthdate']));
            $userForm->setAddress($row['address']);

            $form = $this->createFormBuilder($userForm)
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
                    $data = $form->getData();

                    $username = $data->getUserName();
                    $name = $data->getName();
                    $email = $data->getEmail();
                    $enable = $data->getEnable();
                    $birthdate = $data->getBirthDate();
                    $birthdate = $birthdate->format('Y-m-d H:i:s');
                    $address = $data->getAddress();
                    
                    $sql = "UPDATE users06 SET username='$username', name='$name', email='$email', enable='$enable', birthdate='$birthdate', address='$address' WHERE id=$id";

                    if ($this->conn->query($sql) === TRUE){
                        error_log("Data updated successfully \n");
                        $log = "Data updated successfully";
                        // return $this->redirectToRoute('update', ['id' => $id]);
                    }else{
                        $error_log = "Error: " . $this->conn->error;
                    }
                }
            }    
        
            return $this->render('update.html.twig', array('form' => $form->createView(), 'log' => $log));
        
        }else{
            return new Response ("no user");
        }

    }


}



?>