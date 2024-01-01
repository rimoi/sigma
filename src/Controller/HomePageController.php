<?php

namespace App\Controller;

use App\Constant\MissionTypeConstant;
use App\Entity\Article;
use App\Entity\Mission;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(EntityManagerInterface $entityManager)
    {
        $filter = [
            'published' => true,
            'archived' => false,
        ];

        $articles = $entityManager->getRepository(Article::class)->findBy($filter, ['id' => 'DESC'], 4);
        $missions = $entityManager->getRepository(Mission::class)->findBy(
            $filter + ['type' => MissionTypeConstant::SERVICE],
            ['id' => 'DESC'],
            4
        );

        return $this->renderForm('homepage/homepage.html.twig', [
            'articles' => $articles,
            'missions' => $missions,
            'photo_directory' => $this->getParameter('app.relative_path.image_directory'),
        ]);
    }
}