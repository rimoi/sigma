<?php

namespace App\Controller\BackOffice;

use App\Entity\About;
use App\Form\AboutType;
use App\Repository\AboutRepository;
use App\Service\QualificationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/back/office/about')]
class AboutController extends AbstractController
{
    #[Route('/', name: 'app_back_office_about_index', methods: ['GET'])]
    public function index(AboutRepository $aboutRepository): Response
    {
        return $this->render('back_office/about/index.html.twig', [
            'abouts' => $aboutRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_back_office_about_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, QualificationService $qualificationService): Response
    {
        $about = new About();
        $form = $this->createForm(AboutType::class, $about);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $qualificationService->addElement($form, 'backgroundImage');
            $qualificationService->addElement($form, 'firstFile');
            $qualificationService->addElement($form, 'secondFile');

            $entityManager->persist($about);
            $entityManager->flush();

            return $this->redirectToRoute('app_back_office_about_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back_office/about/new.html.twig', [
            'about' => $about,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_office_about_show', methods: ['GET'])]
    public function show(About $about): Response
    {
        return $this->render('back_office/about/show.html.twig', [
            'about' => $about,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_back_office_about_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, About $about, EntityManagerInterface $entityManager, QualificationService $qualificationService): Response
    {
        $form = $this->createForm(AboutType::class, $about);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $qualificationService->addElement($form, 'backgroundImage');
            $qualificationService->addElement($form, 'firstFile');
            $qualificationService->addElement($form, 'secondFile');

            $entityManager->flush();

            return $this->redirectToRoute('app_back_office_about_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back_office/about/edit.html.twig', [
            'about' => $about,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_back_office_about_delete', methods: ['POST'])]
    public function delete(Request $request, About $about, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$about->getId(), $request->request->get('_token'))) {
            $entityManager->remove($about);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_back_office_about_index', [], Response::HTTP_SEE_OTHER);
    }
}
