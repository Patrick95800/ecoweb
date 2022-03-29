<?php

namespace App\Controller;

use App\Repository\TrainingRepository;
use App\Repository\TrainingSectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/formations')]
class TrainingController extends AbstractController
{
    #[Route('', name: 'trainings')]
    public function index(TrainingRepository $trainingRepository): Response
    {
        return $this->render('training/index.html.twig', [
            'trainings' => $trainingRepository->findAll()
        ]);
    }

    #[Route('/test', name: 'trainings-test')]
    public function index2(TrainingRepository $trainingRepository): Response
    {
        return $this->render('training/index2.html.twig', [
            'trainings' => $trainingRepository->findAll()
        ]);
    }

    #[Route('/{slug}', name: 'trainings_show')]
    public function show(TrainingRepository $trainingRepository, string $slug): Response
    {
        return $this->render('training/show.html.twig', [
            'training' => $trainingRepository->findOneBySlug($slug),
        ]);
    }

    #[Route('/{slug}/sections/{sectionSlug}', name: 'trainings_show_section')]
    public function showSection(TrainingRepository $trainingRepository, TrainingSectionRepository $trainingSectionRepository, string $slug, string $sectionSlug): Response
    {
        return $this->render('training/show_section.html.twig', [
            'training' => $trainingRepository->findOneBySlug($slug),
            'trainingSection' => $trainingSectionRepository->findOneBySlug($sectionSlug),
        ]);
    }
}