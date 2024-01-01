<?php

namespace App\Controller;

use App\Constant\MissionTypeConstant;
use App\Entity\Booking;
use App\Entity\Mission;
use App\Form\SearchType;
use App\Service\NotificationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;
use App\Entity\File as FileEntity;

class MissionFrontController extends AbstractController
{
    #[Route('/projets', name: 'front_mission')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $projects = $entityManager->getRepository(Mission::class)->findBy(
            [
                'archived' => false,
                'published' => true,
                'type' => MissionTypeConstant::PROJECT,
            ],
            ['id' => 'DESC']);

        return $this->renderForm('mission_front/index.html.twig', [
            'projects' => $projects,
            'directory' => $this->getParameter('app.image_directory')
        ]);
    }

    #[Route('/{id}/consuler', name: 'front_mission_consulter')]
    public function consuler(Request $request, FileEntity $fichier): BinaryFileResponse
    {
        $file = new File($this->getParameter('app.image_directory').'/'.$fichier->getName());

        return $this->file($file, $fichier->getName() , ResponseHeaderBag::DISPOSITION_INLINE);
    }

    #[Route('/{slug}/voir', name: 'front_mission_show')]
    public function show(Request $request, EntityManagerInterface $em, ?string $slug = null, ?int $id = null): Response
    {
        if ($slug) {
            $mission = $em->getRepository(Mission::class)->findOneBy(['slug' => $slug]);
        } else {
            throw $this->createNotFoundException('Mission non trouvé !');
        }

        if (!$mission) {
            throw $this->createNotFoundException('Mission non trouvé');
        }

        return $this->render('mission_front/show.html.twig', [
            'mission' => $mission,
        ]);
    }
}
