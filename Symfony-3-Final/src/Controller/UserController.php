<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\JsonResponse;

final class UserController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {

        if($request->request->get('login_ajax') && $this->getUser()){
            $arrData = ['output' => 'Successfully logged in!'];
            return new JsonResponse($arrData);
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $last_username = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', array('error' => $error, 'last_username' => $last_username));
    }


    #[Route('/login_check', name: 'app_login_check', methods: ['POST'])]
    public function loginCheck(){
   
    }
}
