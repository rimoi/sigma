<?php

namespace App\Controller;

use App\Repository\FluxRssRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FluxRssController extends AbstractController
{
    #[Route('/flux/rss', name: 'app_flux_rss')]
    public function index(FluxRssRepository $fluxRssRepository): Response
    {
        return $this->render('flux_rss/index.html.twig', [
            'flux_rss' => $fluxRssRepository->findAll(),
        ]);
    }
}
