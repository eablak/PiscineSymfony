<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;



final class UserController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {

        $error = $authenticationUtils->getLastAuthenticationError();
        $last_username = $authenticationUtils->getLastUsername();

        return $this->render('login/login.html.twig', array('error' => $error, 'last_username' => $last_username));
    }


    #[Route('/ajax/login', name: 'ajaxLogin', methods: ['POST'])]
    public function loginCheck(Request $request, UserRepository $userRepository, TokenStorageInterface $tokenStorage){ 

        $username = $request->request->get('username');
        $password = $request->request->get('password');

        $user = $userRepository->findOneBy(['username' => $username]);

        if (!$user) {
            return new JsonResponse(['error' => 'Invalid Credentials!']);
        }

        if (!password_verify($password, $user->getPassword())) {
            return new JsonResponse(['error' => 'Invalid Credentials!']);
        }

        $token = new UsernamePasswordToken($user, 'main', $user->getRoles());
        $tokenStorage->setToken($token);
        $request->getSession()->set('_security_main', serialize($token));

        return new JsonResponse(['success' => 'Succesfully Login!']);
    }
}
