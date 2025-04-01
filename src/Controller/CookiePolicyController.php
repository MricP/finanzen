<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CookiePolicyController extends AbstractController
{
    #[Route('/cookie/policy', name: 'app_cookie_policy')]
    public function index(): Response
    {
        return $this->render('cookie_policy/index.html.twig', [
            'controller_name' => 'CookiePolicyController',
        ]);
    }
}
