<?php

namespace App\Controller;

use App\Entity\ListeArticle;
use App\Form\ListeArticleType;
use App\Repository\ListeArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/liste/article')]
final class ListeArticleController extends AbstractController
{
    #[Route(name: 'app_liste_article_index', methods: ['GET'])]
    public function index(ListeArticleRepository $listeArticleRepository): Response
    {
        return $this->render('liste_article/index.html.twig', [
            'liste_articles' => $listeArticleRepository->findAll(),
        ]);
    }

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

            return $this->redirectToRoute('app_liste_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('liste_article/edit.html.twig', [
            'liste_article' => $listeArticle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_liste_article_delete', methods: ['POST'])]
    public function delete(Request $request, ListeArticle $listeArticle, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$listeArticle->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($listeArticle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_liste_article_index', [], Response::HTTP_SEE_OTHER);
    }
}
