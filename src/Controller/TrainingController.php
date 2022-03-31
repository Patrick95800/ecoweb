<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\TrainingRepository;
use App\Repository\TrainingSectionRepository;
use App\Repository\UserRepository;
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

    #[Route('/{slug}/sections/{sectionSlug}/lecon/{lessonId}/confirmation', name: 'trainings_mark_lesson_as_done')]
    public function markAsDone(TrainingRepository $trainingRepository, UserRepository $userRepository, string $slug, string $sectionSlug, int $lessonId): Response
    {
        if (null === $user = $this->getUser()) {
            return $this->redirectToRoute('login');
        }

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

        /** @var User $user */
        if (!$user->hasLearnedLesson($lesson)) {
            $user->addLearnedLesson($lesson);
            $userRepository->add($user);

            $this->addFlash('success', sprintf('Félicitations, vous venez de terminer la lecon "%s" !', $lesson->getTitle()));
        }

        return $this->redirectToRoute('trainings_show_section', ['slug' => $slug, 'sectionSlug' => $sectionSlug]);
    }
}