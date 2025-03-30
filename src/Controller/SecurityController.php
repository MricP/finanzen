<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class SecurityController extends AbstractController
{
    #[Route('/upload-profile-picture', name: 'app_upload_profile_picture', methods: ['POST'])]
    public function uploadProfilePicture(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $file = $request->files->get('profile-picture');

        if (!$file) {
            return new JsonResponse(['error' => 'Aucun fichier téléchargé'], 400);
        }

        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
        if (!in_array($file->getMimeType(), $allowedMimeTypes)) {
            return new JsonResponse(['error' => 'Le fichier doit être une image JPEG, PNG ou GIF'], 400);
        }

        $uploadDir = $this->getParameter('kernel.project_dir') . '/public/images/user-profile';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = uniqid() . '.' . $file->guessExtension();
        $file->move($uploadDir, $fileName);

        $user = $this->getUser();
        if (!$user) {
            return new JsonResponse(['error' => 'Utilisateur non authentifié'], 401);
        }

        $user->setImage($fileName);
        $entityManager->flush();

        return new JsonResponse(['success' => true, 'imagePath' =>  $fileName]);
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $user = new User();
        $user->setIsAdmin(false);
        $user->setImage('default-user-icon.svg'); 
        $user->setYearSpend(0);
        $user->setMonthSpend(0);
        $user->setMonthBudget(0);

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            $entityManager->persist($user);
            $entityManager->flush();

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

        if ($user) {
            return $this->redirectToRoute('app_home');
        }

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
            return $this->redirectToRoute('app_home');
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

    #[Route(path: '/get-infos-user', name: 'app_get_infos')]
    public function get_infos(): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->json([
                'error' => 'User not authenticated'
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->json([
            'email' => $user->getUserIdentifier(),
            'pseudo' => $user->getPseudo(),
        ]);
    }

    #[Route(path: '/change-infos-user', name: 'app_change_infos', methods: ['POST'])]
    public function change_infos(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $user = $this->getUser();

        // Vérifier que l'utilisateur implémente PasswordAuthenticatedUserInterface
        if (!$user instanceof PasswordAuthenticatedUserInterface) {
            return $this->json(['error' => 'User not authenticated or invalid user'], Response::HTTP_UNAUTHORIZED);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['pseudo'])) {
            $user->setPseudo($data['pseudo']);
        }

        if (!empty($data['oldPassword']) && !empty($data['newPassword'])) {
            if (!$passwordHasher->isPasswordValid($user, $data['oldPassword'])) {
                return $this->json(['error' => 'Ancien mot de passe incorrect'], Response::HTTP_BAD_REQUEST);
            }

            $user->setPassword($passwordHasher->hashPassword($user, $data['newPassword']));
        }

        $entityManager->flush();

        return $this->json(['success' => 'Informations mises à jour']);
    }
}
