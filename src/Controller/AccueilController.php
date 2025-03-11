<?php

namespace App\Controller;

use App\Repository\ListeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccueilController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(ListeRepository $listeRepository): Response
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'listes' => $listeRepository->findAll(),
        ]);
    }
}
