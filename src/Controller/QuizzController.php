<?php

namespace App\Controller;

use App\Repository\QuizzRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizzController extends AbstractController
{
    #[Route('/quizz/{id}', name: 'quizzes_show')]
    public function show(QuizzRepository $quizzRepository, int $id): Response
    {
        return $this->render('quizz/show.html.twig', [
            'quizz' => $quizzRepository->find($id),
        ]);
    }
}