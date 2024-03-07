<?php

namespace App\Controller;

use App\Repository\YoutubeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(YoutubeRepository $youtubeRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'youtubes' => $youtubeRepository->findAll(),
        ]);
    }
}
