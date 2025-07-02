<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Evenement;
use App\Form\EventTypeForm;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

final class EventController extends AbstractController
{
    #[Route('/evenement/nouveau', name: 'app_evenement_nouveau')]
public function new(Request $request, EntityManagerInterface $em): Response
{
    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

    $evenement = new Evenement();
    $form = $this->createForm(EventTypeForm::class, $evenement);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $evenement->setLeUtilisateur($this->getUser());
        $em->persist($evenement);
        $em->flush();

        $this->addFlash('success', 'Événement créé avec succès !');

        return $this->redirectToRoute('app_dashboard');
    }

    return $this->render('event/new.html.twig', [
        'form' => $form->createView(),
    ]);
}
}
