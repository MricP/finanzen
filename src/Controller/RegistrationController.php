<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Email;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        // Validation de l'email
        if ($form->isSubmitted() && $form->isValid()) {
            $email = $user->getEmail();
            $existingUser = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

            if ($existingUser) {
                // Si un utilisateur avec cet email existe déjà, ajoute un message d'erreur
                $this->addFlash('error', 'An account with this email already exists.');
                return $this->redirectToRoute('app_register');
            }

            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // Hashage du mot de passe
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            $entityManager->persist($user);
            $entityManager->flush();

            // On peut ajouter des actions supplémentaires comme l'envoi d'un email de confirmation
            $this->addFlash('success', 'Registration successful!');

            // Redirection après inscription
            return $this->redirectToRoute('app_liste_index');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
