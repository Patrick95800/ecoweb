<?php

namespace App\Controller\Backend;

use App\Entity\File;
use App\Entity\Training;
use App\Form\Backend\TrainingType;
use App\Repository\FileRepository;
use App\Repository\TrainingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/formations')]
class TrainingController extends AbstractController
{
    #[Route('/', name: 'backend_trainings', methods: ['GET'])]
    public function index(TrainingRepository $trainingRepository): Response
    {
        return $this->render('backend/training/index.html.twig', [
            'trainings' => $trainingRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'backend_trainings_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FileRepository $fileRepository, TrainingRepository $trainingRepository): Response
    {
        $training = new Training();
        $form = $this->createForm(TrainingType::class, $training);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle image
            $imageFile = $form->get('image')->getData();
            if (null !== $imageFile) {
                $extension = $imageFile->guessExtension();
                $fileName = md5(uniqid()) . '.' . $extension;
                $imageFile->move($this->getParameter('uploads_directory'), $fileName);

                $image = new File();
                $image->setName($fileName);
                $image->setExtension($extension);
                $fileRepository->add($image);

                $training->setImage($image);
            }

            $trainingRepository->add($training);
            return $this->redirectToRoute('backend_trainings', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/training/new.html.twig', [
            'training' => $training,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'backend_trainings_show', methods: ['GET'])]
    public function show(Training $training): Response
    {
        return $this->render('backend/training/show.html.twig', [
            'training' => $training,
        ]);
    }

    #[Route('/{id}/edit', name: 'backend_trainings_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Training $training, FileRepository $fileRepository, TrainingRepository $trainingRepository): Response
    {
        $form = $this->createForm(TrainingType::class, $training);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle image
            $imageFile = $form->get('image')->getData();
            if (null !== $imageFile) {
                $extension = $imageFile->guessExtension();
                $fileName = md5(uniqid()) . '.' . $extension;
                $imageFile->move($this->getParameter('uploads_directory'), $fileName);

                $image = new File();
                $image->setName($fileName);
                $image->setExtension($extension);
                $fileRepository->add($image);

                $training->setImage($image);
            }

            $trainingRepository->add($training);
            return $this->redirectToRoute('backend_trainings', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/training/edit.html.twig', [
            'training' => $training,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'backend_trainings_delete', methods: ['POST'])]
    public function delete(Request $request, Training $training, TrainingRepository $trainingRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$training->getId(), $request->request->get('_token'))) {
            $trainingRepository->remove($training);
        }

        return $this->redirectToRoute('backend_trainings', [], Response::HTTP_SEE_OTHER);
    }
}
