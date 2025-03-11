<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_liste_index');
        }

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            $entityManager->persist($user);
            $entityManager->flush();

            // Stocker l'email en session pour retrouver l'utilisateur ensuite
            $session->set('from_registration', true);
            $session->set('user_email', $user->getEmail());

            return $this->redirectToRoute('app_set_pseudo');
        }

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/set-pseudo', name: 'app_set_pseudo')]
    public function setPseudo(Request $request, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $user = $this->getUser();
        $fromRegistration = $session->get('from_registration', false);
        $userEmail = $session->get('user_email', '');

        // Si l'utilisateur n'est pas connecté, on le cherche en BDD via l'email stocké
        if (!$user instanceof User && $userEmail) {
            $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $userEmail]);
        }

        if (!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }

        if ($fromRegistration) {
            $session->remove('from_registration');
        }

            $form = $this->createFormBuilder($user)
            ->add('pseudo')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/set_pseudo.html.twig', [
            'form' => $form->createView(),
            'user_email' => $user->getEmail(),
        ]);
    }

    #[Route(path: '/', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $user = $this->getUser();

        if ($user instanceof User) {
            if (!$user->getPseudo()) {
                return $this->redirectToRoute('app_set_pseudo');
            }
            return $this->redirectToRoute('app_liste_index');
        }

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
