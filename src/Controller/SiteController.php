<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// ne pas oublier de rajouter les lignes use...
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Newsletter;
use App\Form\NewsletterType;

class SiteController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $newsletter = new Newsletter(); // code créé avec le make:entity
        $form = $this->createForm(NewsletterType::class, $newsletter);
        $form->handleRequest($request);

        // bloc if pour le traitement du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            // alors on traite le formulaire

            // ici on peut compléter les infos manquantes
            $objetDate = new \DateTime();   // objet qui contient la date actuelle
            $newsletter->setDateInscription($objetDate);
    
            // on envoie les infos en base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newsletter);
            $entityManager->flush();

            // pas de redirection pour la page d'accueil
            // return $this->redirectToRoute('newsletter_index');
        }


        return $this->render('site/index.html.twig', [
            'controller_name' => 'SiteController',
            'form' => $form->createView(),
            'controller_name' => 'SiteController',
        ]);
    }

    #[Route('/galerie', name: 'galerie')]
    public function galerie(): Response
    {
        return $this->render('site/galerie.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('site/contact.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }
}
