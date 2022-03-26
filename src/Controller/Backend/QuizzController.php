<?php

namespace App\Controller\Backend;

use App\Entity\Quizz;
use App\Form\Backend\QuizzType;
use App\Repository\QuizzRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/quizz')]
class QuizzController extends AbstractController
{
    #[Route('/', name: 'backend_quizzes', methods: ['GET'])]
    public function index(QuizzRepository $quizzRepository): Response
    {
        return $this->render('backend/quizz/index.html.twig', [
            'quizzes' => $quizzRepository->findAll(),
        ]);
    }

    #[Route('/nouveau', name: 'backend_quizzes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, QuizzRepository $quizzRepository): Response
    {
        $quizz = new Quizz();
        $form = $this->createForm(QuizzType::class, $quizz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quizzRepository->add($quizz);
            return $this->redirectToRoute('backend_quizzes', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/quizz/new.html.twig', [
            'quizz' => $quizz,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'backend_quizzes_show', methods: ['GET'])]
    public function show(Quizz $quizz): Response
    {
        return $this->render('backend/quizz/show.html.twig', [
            'quizz' => $quizz,
        ]);
    }

    #[Route('/{id}/edition', name: 'backend_quizzes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Quizz $quizz, QuizzRepository $quizzRepository): Response
    {
        $form = $this->createForm(QuizzType::class, $quizz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quizzRepository->add($quizz);
            return $this->redirectToRoute('backend_quizzes', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('quizz/edit.html.twig', [
            'quizz' => $quizz,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'backend_quizzes_delete', methods: ['POST'])]
    public function delete(Request $request, Quizz $quizz, QuizzRepository $quizzRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$quizz->getId(), $request->request->get('_token'))) {
            $quizzRepository->remove($quizz);
        }

        return $this->redirectToRoute('backend_quizzes', [], Response::HTTP_SEE_OTHER);
    }
}
