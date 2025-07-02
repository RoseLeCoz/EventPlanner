<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Utilisateur;

final class DashboardController extends AbstractController
{
    #[Route('/tableau_de_bord', name: 'app_dashboard')]
    public function index(): Response
{
    /** @var Utilisateur $utilisateur */
    $utilisateur = $this->getUser();
    $evenements = $utilisateur->getLesEvenements();

    return $this->render('dashboard/index.html.twig', [
        'utilisateur' => $utilisateur,
        'evenements' => $evenements,
    ]);
}
}
