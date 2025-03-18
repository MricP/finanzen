<?php

namespace App\Controller;

use App\Repository\ListeArticleRepository; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class StatisticController extends AbstractController
{
    #[Route('/statistic', name: 'app_statistic')]
    public function index(ListeArticleRepository $listeArticleRepository): Response
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

        return $this->render('statistic/index.html.twig', [
            'controller_name' => 'StatisticController',
            'user' => $this->getUser(),
            'liste_article'=> number_format($moyennePrix, 2), 
            'article_max' => number_format($articleLePlusCher, 2),
            'article_min' => number_format($articleLeMoinsCher, 2),
            
        ]);
    }
}
