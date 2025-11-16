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


class RelationalController extends AbstractController{

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

    #[Route('e08/add_column', methods: ['GET', 'POST'])]
        public function ft_add_column(){
            return $this->render('Relational/column.html.twig');
        }

        public function add_column(){
            $sql = "ALTER TABLE person ADD marital_status enum('single','married', 'widower')";

            $conn_info = "";
            try{
                $this->conn = mysqli_connect($this->db_server, $this->db_user, $this->db_pass, $this->db_name);

                if ($this->conn){
                    if ($this->conn->query($sql) === TRUE){
                        $conn_info = "Column created succesfully";
                    }else{
                        $conn_info = "Error creating column";
                        $this->conn->error;
                    }
                }
            }catch(mysqli_sql_exception){
                echo "Could not connect \n";
            }
            return new Response($conn_info);
        }

    #[Route('e08/create_tables', methods: ['GET', 'POST'])]
    public function ft_create_tables(){
        return $this->render('Relational/tables.html.twig');
    }

    public function bank_accounts_table(){

        $sql = "
            CREATE TABLE IF NOT EXISTS BankAccounts (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT UNIQUE,
                account_id varchar(50),
                name varchar(255),
                password varchar(255),
                FOREIGN KEY (user_id) REFERENCES person(id) ON DELETE CASCADE
            )";

        $conn_info = "";
        if ($this->conn->query($sql) === TRUE){
            $conn_info = "Bank Account table created successfully";
        }else{
            $conn_info = "Error creating table: " . $this->conn->error;
        }
        return new Response($conn_info);
    }


    public function addresses_table(){

        $sql = "
            CREATE TABLE IF NOT EXISTS Addresses (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT,
                name varchar(255),
                address varchar(255),
                FOREIGN KEY (user_id) REFERENCES person(id) ON DELETE CASCADE
            )";

        $conn_info = "";
        if ($this->conn->query($sql) === TRUE){
            $conn_info = "Address table created successfully";
        }else{
            $conn_info = "Error creating table: " . $this->conn->error;
        }
        return new Response($conn_info);
    }

}



?>