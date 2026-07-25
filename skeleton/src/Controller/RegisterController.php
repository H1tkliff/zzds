<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    public function register(
        Request                     $request,
        EntityManagerInterface      $em,
        UserPasswordHasherInterface $userPasswordHasher,
        UserAuthenticatorInterface  $userAuthenticator,
        AppAuthenticator            $authenticator
    ): Response
    {
        $user = new User();

        if ($this->getUser()) {
            return $this->redirectToRoute('app_account');
        }

        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hash = $userPasswordHasher->hashPassword($user,
                $user->getPassword());
            $user->setPassword($hash);
            $user->setRoles(['ROLE_USER']);

            $em->persist($user);
            $em->flush();

            return $userAuthenticator->authenticateUser($user, $authenticator, $request);
        }

        return $this->render('page/account/security/login.html.twig', [
            'form' => $form->createView(),
            'active_tab' => 'register',
            'error' => null,
            'last_username' => null,
        ]);
    }
}