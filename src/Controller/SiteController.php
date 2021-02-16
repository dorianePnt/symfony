<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// ne pas oublier de rajouter les lignes use...
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Newsletter;
use App\Form\NewsletterType;

use App\Entity\Contact;
use App\Form\ContactType;

// use App\Repository\AnnonceRepository;



class SiteController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $messageConfirmation    = 'merci de remplir le formulaire';
        $classConfirmation      = 'gris';

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

            // tout c'est bien passé
            $messageConfirmation    = 'merci de votre inscription';
            $classConfirmation      = 'vert';

            // pas de redirection pour la page d'accueil
            // return $this->redirectToRoute('newsletter_index');
        }


        return $this->render('site/index.html.twig', [
            'classConfirmation'    => $classConfirmation,
            'messageConfirmation' => $messageConfirmation,  //tuyau de transmission entre PHP et twig
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


    
    // #[Route('/annonce', name: 'annonce', methods: ['GET'])]
    // public function annonce(AnnonceRepository $annonceRepository): Response
    // {
    //     return $this->render('annonce/index.html.twig', [
    //         'annonces' => $annonceRepository->findAll(),
    //     ]);
    // }




    #[Route('/contact', name: 'contact', methods: ['GET', 'POST'])]
    public function contact(Request $request): Response
    {

        $messageConfirmation    = 'merci de remplir le formulaire';
        $classConfirmation      = 'gris';

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // ici on peut compléter les infos manquantes
            $objetDate = new \DateTime();   // objet qui contient la date actuelle
            $contact->setDateMessage($objetDate);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            // return $this->redirectToRoute('contact_index');
            $messageConfirmation    = 'merci de votre inscription';
            $classConfirmation      = 'vert';
        }

        return $this->render('site/contact.html.twig', [
            'classConfirmation'    => $classConfirmation,
            'messageConfirmation' => $messageConfirmation,  //tuyau de transmission entre PHP et twig

            'contact' => $contact,
            'form' => $form->createView(),
            'controller_name' => 'SiteController',
        ]);
    }
}
