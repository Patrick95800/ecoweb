<?php

namespace App\Controller;

use App\Form\Backend\UserType;
use App\Manager\MailerManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CandidateController extends AbstractController
{
    #[Route('/candidate', name: 'candidate')]
    public function index(Request $request, MailerManager $mailerManager): Response
    {
        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mailerManager->sendContactMessage($form->getData());

            $this->addFlash('success', 'Votre message a bien été envoyé !');

            return $this->redirectToRoute('candidate');
        }

        return $this->render('candidate/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
