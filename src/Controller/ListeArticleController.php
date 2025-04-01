<?php

namespace App\Controller;

use App\Entity\ListeArticle;
use App\Form\ListeArticleType;
use App\Repository\ListeArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/liste/article')]
final class ListeArticleController extends AbstractController
{
    #[Route('/new', name: 'app_liste_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $listeArticle = new ListeArticle();
        $form = $this->createForm(ListeArticleType::class, $listeArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($listeArticle);
            $entityManager->flush();

            return $this->redirectToRoute('app_liste_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('liste_article/new.html.twig', [
            'liste_article' => $listeArticle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_liste_article_show', methods: ['GET'])]
    public function show(ListeArticle $listeArticle): Response
    {
        return $this->render('liste_article/show.html.twig', [
            'liste_article' => $listeArticle,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_liste_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ListeArticle $listeArticle, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ListeArticleType::class, $listeArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('liste_article/_form_edit.html.twig', [
            'liste_article' => $listeArticle,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_liste_article_delete', methods: ['POST'])]
    public function delete(Request $request, ListeArticle $listeArticle, EntityManagerInterface $entityManager): JsonResponse
    {
        if ($this->isCsrfTokenValid('delete'.$listeArticle->getId(), $request->request->get('_token'))) {
            $entityManager->remove($listeArticle);
            $entityManager->flush();
            
            return new JsonResponse(['status' => 'success'], 200);
        }
        
        return new JsonResponse([
            'status' => 'error', 
            'message' => 'Invalid CSRF token'
        ], 400);
    }

    #[Route('/add/{liste_id}', name: 'app_liste_article_add', methods: ['POST'])]
    public function addArticle(Request $request, int $liste_id, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);

            if (!$data || !isset($data['articles']) || !is_array($data['articles'])) {
                return new JsonResponse(['status' => 'error', 'message' => 'Données invalides'], 400);
            }
            error_log("liste id" . $liste_id);
            $liste  = $entityManager->getRepository(\App\Entity\Liste::class)->find($liste_id);
            if (!$liste) {
                return new JsonResponse(['status' => 'error', 'message' => 'Liste non trouvée'], 404);
            }

            foreach ($data['articles'] as $articleData) {
                $articleId = $articleData['id'];
                $quantity = $articleData['quantity'];

                $article = $entityManager->getRepository(\App\Entity\Article::class)->find($articleId);
                if (!$article) {
                    return new JsonResponse(['status' => 'error', 'message' => "Article avec l'ID {$articleId} non trouvé"], 404);
                }

                $listeArticle = new ListeArticle();
                $listeArticle->setArticles($article);
                $listeArticle->setListes($liste);
                $listeArticle->setQuantite($quantity);
                $listeArticle->setEstAchete(false);

                $entityManager->persist($listeArticle);
            }

            $entityManager->flush();
            
            return new JsonResponse(['status' => 'success']);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return new JsonResponse(['status' => 'error', 'message' => 'Une erreur est survenue.'], 500);
        }
    }

    #[Route('/update-quantity/{id}', name: 'app_liste_article_update_quantity', methods: ['POST'])]
    public function updateQuantity(Request $request, ListeArticle $listeArticle, EntityManagerInterface $entityManager): JsonResponse
    {
        if ($request->isXmlHttpRequest()) {
            $data = json_decode($request->getContent(), true);
            $newQuantity = $data['quantity'];

            $listeArticle->setQuantite($newQuantity);
            $entityManager->flush();

            return new JsonResponse(['status' => 'Quantity updated'], 200);
        }

        return new JsonResponse(['status' => 'Invalid request'], 400);
    }
}