<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PseudoController extends AbstractController
{
    #[Route('/set-pseudo', name: 'app_set_pseudo')]
    public function setPseudo(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        
        // if (!$user) {
        //     return $this->redirectToRoute('app_login');
        // }

        // if ($user->getPseudo()) {
        //     return $this->redirectToRoute('app_liste_index'); // La page principale après connexion
        // }

        $form = $this->createFormBuilder($user)
            ->add('pseudo') 
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush(); 
            return $this->redirectToRoute('app_liste_index');  
        }

        return $this->render('pseudo/set_pseudo.html.twig', [
            'form' => $form->createView(),
            'user_email' => "fillouxflorian56@gmail.com" 
        ]);
    }
}
