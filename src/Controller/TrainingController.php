<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrainingController extends AbstractController
{
    #[Route('/formations', name: 'trainings')]
    public function index(): Response
    {
        return $this->render('training/index.html.twig');
    }
    #[Route('/formation', name: 'trainings_show')]
    public function show(): Response
    {
        return $this->render('training/show.html.twig');
    }
}