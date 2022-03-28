<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\TeacherRequest;
use App\Form\TeacherRequestType;
use App\Manager\MailerManager;
use App\Repository\FileRepository;
use App\Repository\TeacherRequestRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{
    #[Route('/devenir-formateur', name: 'teacher_ask')]
    public function ask(Request $request, UserPasswordHasherInterface $passwordHasher, UserRepository $userRepository, FileRepository $fileRepository, TeacherRequestRepository $teacherRequestRepository, MailerManager $mailerManager): Response
    {
        $teacherRequest = new TeacherRequest();
        $form = $this->createForm(TeacherRequestType::class, $teacherRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if (null !== $existingUser = $userRepository->findOneByEmail($teacherRequest->getEmail())) {
                $form->get('email')->addError(new FormError('Un utilisateur est déjà enregistré avec cette adresse email. Veuillez saisir une autre adresse email'));
            }

            if (null !== $existingTeacherRequest = $teacherRequestRepository->findOneByEmail($teacherRequest->getEmail())) {
                $form->get('email')->addError(new FormError('Un utilisateur a déjà fait une demande pour devenir formateur, avec cette adresse email. Veuillez saisir une autre adresse email'));
            }

            if ($form->isValid()) {
                $plainPassword = $form->get('plainPassword')->getData();

                if (!empty($plainPassword)) {
                    $hashedPassword = $passwordHasher->hashPassword($teacherRequest, $plainPassword);
                    $teacherRequest->setPassword($hashedPassword);
                }

                // Handle photo
                $photoFile = $form->get('photo')->getData();
                if (null !== $photoFile) {
                    $extension = $photoFile->guessExtension();
                    $fileName = md5(uniqid()) . '.' . $extension;
                    $photoFile->move($this->getParameter('uploads_directory'), $fileName);

                    $photo = new File();
                    $photo->setName($fileName);
                    $photo->setExtension($extension);
                    $fileRepository->add($photo);

                    $teacherRequest->setPhoto($photo);
                }

                $teacherRequestRepository->add($teacherRequest);

                $mailerManager->sendNewTeacherRequestMessage($form->getData());

                $this->addFlash('success', 'Votre demande a bien été envoyé. Nous reviendrons vers vous dès que possible.');

                return $this->redirectToRoute('teacher_ask');
            }
        }

        return $this->render('teacher/ask.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
