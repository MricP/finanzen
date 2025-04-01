<?php

namespace App\Controller;

use App\Repository\ListeRepository;
use App\Repository\ListeArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccueilController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(ListeRepository $listeRepository, ListeArticleRepository $listeArticleRepository): Response
    {

        $listeArticles = $listeArticleRepository->findAll();
    
        if (empty($listeArticles)) {
            $moyennePrix = 0;
            $articleLePlusCher = 0;
            $articleLeMoinsCher = 0;
        } else {
            $totalPrix = 0;
            $count = 0;
            foreach ($listeArticles as $listeArticle) {
                $prix = $listeArticle->getArticles()->getPrix();
                $count++;
                $totalPrix = $totalPrix + $prix;
                $prixArticles[] = $prix;
            }
    
            $moyennePrix = $totalPrix / $count;
            $articleLePlusCher = max($prixArticles);
            $articleLeMoinsCher = min($prixArticles);
        }


        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'listes' => $listeRepository->findAll(),
            'user'=> $this->getUser(),
            'liste_article'=> number_format($moyennePrix, 2), 
            'article_max' => number_format($articleLePlusCher, 2),
            'article_min' => number_format($articleLeMoinsCher, 2)
        ]);
    }
}
