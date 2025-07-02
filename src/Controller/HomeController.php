<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/accueil', name: 'accueil')]
    public function index(Request $request): Response
    {
        return new Response('Bonjour ' . $request->query->get('name', 'Inconnu'));
    }
}
