<?php
namespace App\Controller;

use App\Entity\Liste;
use App\Form\ListeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;

#[Route('/liste')]
final class ListeController extends AbstractController
{
    #[Route('/new', name: 'app_liste_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $liste = new Liste();
        $form = $this->createForm(ListeType::class, $liste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($liste);
            $entityManager->flush();

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('liste/new.html.twig', [
            'liste' => $liste,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_liste_show', methods: ['GET'])]
    public function show(Liste $liste, ArticleRepository $articleRepository): Response
    {
        $tousLesArticles = $articleRepository->findAll(); 

        return $this->render('liste/show.html.twig', [
            'liste' => $liste,
            'articles' => $tousLesArticles, 
        ]);
    }

    #[Route('/{id}/edit', name: 'app_liste_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Liste $liste, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ListeType::class, $liste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_liste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('liste/edit.html.twig', [
            'liste' => $liste,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_liste_delete', methods: ['POST'])]
    public function delete(Request $request, Liste $liste, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$liste->getId(), $request->request->get('_token'))) {
            $entityManager->remove($liste);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }
}
