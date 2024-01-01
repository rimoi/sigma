<?php

namespace App\Controller;

use App\Repository\AboutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    #[Route('/politics', name: 'app_private_politics')]
    public function privatePolitics(): Response
    {
        return $this->render('about/private_politics.html.twig');
    }

    #[Route('/a-propos', name: 'app_about')]
    public function about(AboutRepository $aboutRepository): Response
    {
        return $this->render('about/about.html.twig', [
            'about' => $aboutRepository->findOneBy([], ['id' => 'DESC']),
        ]);
    }
}
