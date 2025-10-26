<?php

namespace App\Controller;

use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


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



    #[Route('/e00', name: 'home', methods: ['GET','POST'])]
    public function index(){
        
        return $this->render('index.html.twig');
    }


    public function create_table(): Response{

        $sql = "
            CREATE TABLE IF NOT EXISTS USERS (
                id int PRIMARY KEY,
                username varchar(50) UNIQUE,
                name varchar(255),
                email varchar(255) UNIQUE,
                enable BOOLEAN,
                birthdate DATETIME,
                address LONGTEXT
            )";


        $conn_info = "";
        try{
            $this->conn = mysqli_connect($this->db_server, $this->db_user, $this->db_pass, $this->db_name);
            if ($this->conn){

                if ($this->conn->query($sql) === TRUE){
                    $conn_info = "Table created successfully";
                }else{
                    $conn_info = "Error creating table: " . $this->conn->error;
                }
            }
        }catch(mysqli_sql_exception){
            echo "Could not connect \n";
        }

        return new Response($conn_info);
    }

}



?>