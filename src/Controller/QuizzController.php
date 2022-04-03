<?php

namespace App\Controller;

use App\Repository\QuizzRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class QuizzController extends AbstractController
{
    #[Route('/quizz/{id}', name: 'quizzes_show')]
    public function show(Request $request, QuizzRepository $quizzRepository, int $id): Response
    {
        if (null === $quizz = $quizzRepository->find($id)) {
            throw new NotFoundHttpException();
        }

        $displayAnswers = false;
        $postedData = [];

        // If form has been submitted
        if ('POST' === $request->getMethod()) {
            $displayAnswers = true;
            $postedData = $request->request->all();

            $this->addFlash('success', 'Merci d\'avoir passé ce quizz !');
        }

        return $this->render('quizz/show.html.twig', [
            'quizz' => $quizz,
            'posted_data' => $postedData,
            'display_answers' => $displayAnswers,
        ]);
    }
}