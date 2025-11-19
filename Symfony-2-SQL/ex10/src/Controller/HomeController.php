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
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\TABLEORM;


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

    public function create_table_sql(){
        $sql = "
            CREATE TABLE IF NOT EXISTS TABLESQL (
                id INT AUTO_INCREMENT PRIMARY KEY,
                text LONGTEXT
            )";

        if ($this->conn->query($sql) === TRUE){
            error_log("Table created successfully");
        }else{
            error_log("Error creating table: " . $this->conn->error);
        }
        return new Response("");
    }



    #[Route('e10', methods: ['GET', 'POST'])]
    public function index(){

        $this->create_table_sql();
        return $this->render('index.html.twig');
    }


    public function insert_data(EntityManagerInterface $em){

        $file_path = $this->getParameter('kernel.project_dir') . '/read_file.txt';
        if (!file_exists($file_path))
            return new Response("Wrong file path");

        $file = file_get_contents($file_path);
        
        $sql = "INSERT INTO TABLESQL (text) VALUES ('$file')";
        if ($this->conn->query($sql) === TRUE){
            error_log("Data insert successfully \n");
        }else{
            $error_log = "Error: " . $this->conn->error;
            error_log($error_log);
        }
        
        $table = new TABLEORM();
        $table->setText($file);
        $em->persist($table);
        $em->flush();

        return new Response("Text succesfully inserted tables");
    }


    public function read_table(EntityManagerInterface $em){

        $sql = "SELECT * FROM TABLESQL";
        $results_sql = $this->conn->query($sql);

        $results_orm = $em->getRepository(TABLEORM::class)->findAll();

        return $this->render('read.html.twig', array('results_sql' => $results_sql, 'results_orm' => $results_orm));
    }

}



?>