<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Utilisateur;

final class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(): Response
{
    /** @var Utilisateur $utilisateur */
    $utilisateur = $this->getLeUtilisateur();
    $evenement = $utilisateur->getEvenement();

    return $this->render('dashboard/index.html.twig', [
        'utilisateur' => $utilisateur,
        'evenement' => $evenement,
    ]);
}
}
