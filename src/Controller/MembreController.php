<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;



class MembreController extends AbstractController
{
    #[Route('/membre', name: 'membre', methods: ['GET', 'POST'])]
    public function index(Request $request, AnnonceRepository $annonceRepository): Response
    {
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        $messageConfirmation = "";

        // Ajouter l'auteur de l'annonce avec l'utilisateur connecté
        $userConnecte = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {

            // Completer les infos manquantes
            $annonce->setDatePublication(new \DateTime());
            // https://symfony.com/doc/current/security.html#a-fetching-the-user-object
            
            $annonce->setUser($userConnecte);

            // Code qui insere la nouvelle ligne dans SQL
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($annonce);
            $entityManager->flush();

            $messageConfirmation = "Votre annonce est publiée";
        }

        // après le traitement du create pour obtenir la liste à jour
        $annonces = $annonceRepository->findBy([
            "user" => $userConnecte,            
            // on filtre les lignes pour obtenir seulement les annonces de l'utilisateur
        ], [ "datePublication" => "DESC"]);
        

        return $this->render('membre/index.html.twig', [
            'annonce' => $annonce,
            'annonces' => $annonces,    // SELECT * FROM annonces
            'form' => $form->createView(),
            'messageConfirmation' => $messageConfirmation
        ]);
    }

}

