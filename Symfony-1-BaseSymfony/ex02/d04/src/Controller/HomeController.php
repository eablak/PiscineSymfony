<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; 
use App\Entity\MessageForm;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType; 
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 


class HomeController extends AbstractController{

    private string $logFile;

    public function __construct(string $pathFile){
        $this->logFile = $pathFile;
    }


    public function get_last_commit(){
        if (file_exists($this->logFile)){
            $last = "";
            $handle = fopen($this->logFile, "r");
                if ($handle) {
                    while (($line = fgets($handle)) !== false) {
                        $last = $line;
                    }
                    fclose($handle);
                }
                return $last;
        }
        return "";
    }


    #[Route('/e02', name: 'home', methods: ['GET', 'POST'])]
    public function index(Request $request){

        $msgform = new MessageForm();
        $form = $this->createFormBuilder($msgform)
            ->add('message', TextType::class)
            ->add('time', ChoiceType::class,[
                'choices' => [
                    'Yes' => true,
                    'No' => false,
                ],
            ])
            ->add('submit', SubmitType::class, array('label' => 'Submit'))
            ->getForm();
        
        if ($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){

                $msg = $form["message"]->getData();
                $time_confirm = $form["time"]->getData();
                $data = $msg;
                if ($time_confirm){
                    $data .= " " . time();
                }
                
                if (file_exists($this->logFile)){
                    $current = file_get_contents($this->logFile);
                    $current .= "\n";
                    file_put_contents($this->logFile, $current .= $data);
                }
                else {
                    file_put_contents($this->logFile, $data);
                }
                return $this->redirectToRoute('home');
            }
        }

        $last_commit = $this->get_last_commit();
        return $this->render('base.html.twig',array(
            'form' => $form->createView(),
            'last_commit' => $last_commit,
        ));

    }
    
}