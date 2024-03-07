<?php

namespace App\Controller;

use App\Entity\Youtube;
use App\Form\YoutubeType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class YoutubeController extends AbstractController
{
    #[Route('/youtube/new', name: 'new_youtube')]
    public function new(Request $request, FileUploader $fileUploader, EntityManagerInterface $em): Response
    {
        // if (!$this->isGranted('ROLE_ADMIN')) {                 // Permet d'empécher l'accès à cette action si ce n'est pas un admin
        //     throw $this->createAccessDeniedException('Accès non autorisé');
        // }

        $youtube = new Youtube();                           // Créer un objet vide 
        
        $form = $this->createForm(YoutubeType::class, $youtube); // Créer le formulaire de cet objet

        $form->handleRequest($request);                     // Récupérer les données du formulaire

        if($form->isSubmitted() && $form->isValid()) {      // Condition si le formulaire est soumis et valide alors
            
            $youtube = $form->getData();                    // Récupérer les données du formulaire pour remplir l'objet

            $imageFile = $form->get('image')->getData();
           
            //////////////////////////////////////////////////////////////////////////
            // Ces conditions sont nécessaires car les champs image et tome ne sont pas requis
            // Les fichiers jpeg doivent être priorisés seulement quand un fichier est chargé
            
            if ($imageFile) {
                // Envoie les données au Service FileUploader 
                $imageFileName = $fileUploader->upload($imageFile);
                $youtube->setImage($imageFileName);   
            }

            $em->persist($youtube);                         // Gérer le traitement en BDD
            $em->flush();

            return $this->redirectToRoute('app_home');      // Rediriger vers la page d'accueil
        }

        return $this->render('youtube/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
