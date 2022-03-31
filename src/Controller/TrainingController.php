<?php

namespace App\Controller;

use App\Repository\TrainingRepository;
use App\Repository\TrainingSectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
    public function showSection(TrainingRepository $trainingRepository, string $slug, string $sectionSlug): Response
    {
        if (null === $training = $trainingRepository->findOneBySlug($slug)) {
            throw new NotFoundHttpException();
        }

        $trainingSection = null;
        foreach ($training->getSections() as $section) {
            if ($section->getSlug() === $sectionSlug) {
                $trainingSection = $section;
            }
        }

        if (null === $trainingSection) {
            throw new NotFoundHttpException();
        }

        return $this->render('training/show_section.html.twig', [
            'training' => $training,
            'section' => $trainingSection,
        ]);
    }

    #[Route('/{slug}/sections/{sectionSlug}/lecon/{lessonId}', name: 'trainings_show_lesson')]
    public function showLesson(TrainingRepository $trainingRepository, string $slug, string $sectionSlug, int $lessonId): Response
    {
        if (null === $training = $trainingRepository->findOneBySlug($slug)) {
            throw new NotFoundHttpException();
        }

        $trainingSection = null;
        foreach ($training->getSections() as $section) {
            if ($section->getSlug() === $sectionSlug) {
                $trainingSection = $section;
            }
        }

        if (null === $trainingSection) {
            throw new NotFoundHttpException();
        }

        $trainingLesson = null;
        foreach ($trainingSection->getLessons() as $lesson) {
            if ($lesson->getId() === $lessonId) {
                $trainingLesson = $lesson;
            }
        }

        if (null === $trainingLesson) {
            throw new NotFoundHttpException();
        }

        return $this->render('training/show_lesson.html.twig', [
            'training' => $training,
            'section' => $trainingSection,
            'lesson' => $trainingLesson,
        ]);
    }
}