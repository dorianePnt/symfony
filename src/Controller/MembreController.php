<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MembreController extends AbstractController
{
    #[Route('/membre', name: 'membre')]
    public function index(): Response
    {
        return $this->render('membre/index.html.twig', [
            'controller_name' => 'MembreController',
        ]);
    }



    // #[Route('/annonce/new', name: 'annonce_new', methods: ['GET', 'POST'])]
    // public function new(Request $request): Response
    // {
    //     $annonce = new Annonce();
    //     $form = $this->createForm(AnnonceType::class, $annonce);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {

    //         // Completer les infos manquantes
    //         $annonce->setDatePublication(new \DateTime());
    //         // https://symfony.com/doc/current/security.html#a-fetching-the-user-object
    //         // Ajouter l'auteur de l'annonce avec l'utilisateur connecté
    //         $userConnecte = $this->getUser();
    //         $annonce->setUser($userConnecte);

    //         // Code qui insere la nouvelle ligne dans SQL
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->persist($annonce);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('annonce_index');
    //     }

    //     return $this->render('annonce/new.html.twig', [
    //         'annonce' => $annonce,
    //         'form' => $form->createView(),
    //     ]);
    // }

}

