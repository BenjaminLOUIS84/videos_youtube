<?php

namespace App\Controller;

use App\Entity\Youtube;
use App\Form\YoutubeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class YoutubeController extends AbstractController
{
    #[Route('/ADM', name: 'app_youtube')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $youtube = new Youtube();                           // Créer un objet vide 
        
        $form = $this->createForm(YoutubeType::class, $youtube); // Créer le formulaire de cet objet

        $form->handleRequest($request);                     // Récupérer les données du formulaire

        if($form->isSubmitted() && $form->isValid()) {      // Condition si le formulaire est soumis et valide alors
            $youtube = $form->getData();                    // Récupérer les données du formulaire pour remplir l'objet

            $em->persist($youtube);                         // Gérer le traitement en BDD
            $em->flush();

            return $this->redirectToRoute('app_home');      // Rediriger vers la page d'accueil
        }

        return $this->render('youtube/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
