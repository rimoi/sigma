<?php

namespace App\Controller\BackOffice;

use App\Entity\FluxRss;
use App\Form\FluxRssType;
use App\Repository\FluxRssRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/back/office/flux/rss')]
class FluxRssController extends AbstractController
{
    #[Route('/', name: 'app_back_office_flux_rss_index', methods: ['GET'])]
    public function index(FluxRssRepository $fluxRssRepository): Response
    {
        return $this->render('back_office/flux_rss/index.html.twig', [
            'flux_rsses' => $fluxRssRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_back_office_flux_rss_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $fluxRss = new FluxRss();
        $form = $this->createForm(FluxRssType::class, $fluxRss);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($fluxRss);
            $entityManager->flush();

            return $this->redirectToRoute('app_back_office_flux_rss_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back_office/flux_rss/new.html.twig', [
            'flux_rss' => $fluxRss,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_office_flux_rss_show', methods: ['GET'])]
    public function show(FluxRss $fluxRss): Response
    {
        return $this->render('back_office/flux_rss/show.html.twig', [
            'flux_rss' => $fluxRss,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_back_office_flux_rss_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FluxRss $fluxRss, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FluxRssType::class, $fluxRss);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_back_office_flux_rss_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back_office/flux_rss/edit.html.twig', [
            'flux_rss' => $fluxRss,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_office_flux_rss_delete', methods: ['POST'])]
    public function delete(Request $request, FluxRss $fluxRss, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fluxRss->getId(), $request->request->get('_token'))) {
            $entityManager->remove($fluxRss);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_back_office_flux_rss_index', [], Response::HTTP_SEE_OTHER);
    }
}
