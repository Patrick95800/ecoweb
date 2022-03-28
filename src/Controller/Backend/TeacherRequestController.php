<?php

namespace App\Controller\Backend;

use App\Entity\File;
use App\Entity\TeacherRequest;
use App\Entity\User;
use App\Form\Backend\TeacherRequestType;
use App\Repository\FileRepository;
use App\Repository\TeacherRequestRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/demandes-pour-devenir-instructeur')]
class TeacherRequestController extends AbstractController
{
    #[Route('/', name: 'backend_teacher_requests', methods: ['GET'])]
    public function index(TeacherRequestRepository $teacherRequestRepository): Response
    {
        return $this->render('backend/teacher_request/index.html.twig', [
            'teacher_requests' => $teacherRequestRepository->findAll(),
        ]);
    }

    #[Route('/nouveau', name: 'backend_teacher_requests_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserPasswordHasherInterface $passwordHasher, FileRepository $fileRepository, TeacherRequestRepository $teacherRequestRepository): Response
    {
        $teacherRequest = new TeacherRequest();
        $form = $this->createForm(TeacherRequestType::class, $teacherRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
            return $this->redirectToRoute('backend_teacher_requests', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/teacher_request/new.html.twig', [
            'teacher_request' => $teacherRequest,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'backend_teacher_requests_show', methods: ['GET'])]
    public function show(TeacherRequest $teacherRequest): Response
    {
        return $this->render('backend/teacher_request/show.html.twig', [
            'teacher_request' => $teacherRequest,
        ]);
    }

    #[Route('/{id}/edition', name: 'backend_teacher_requests_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TeacherRequest $teacherRequest, UserPasswordHasherInterface $passwordHasher, FileRepository $fileRepository, TeacherRequestRepository $teacherRequestRepository): Response
    {
        $form = $this->createForm(TeacherRequestType::class, $teacherRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
            return $this->redirectToRoute('backend_teacher_requests', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/teacher_request/edit.html.twig', [
            'teacher_request' => $teacherRequest,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'backend_teacher_requests_delete', methods: ['POST'])]
    public function delete(Request $request, TeacherRequest $teacherRequest, TeacherRequestRepository $teacherRequestRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$teacherRequest->getId(), $request->request->get('_token'))) {
            $teacherRequestRepository->remove($teacherRequest);
        }

        return $this->redirectToRoute('backend_teacher_requests', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/validation', name: 'backend_teacher_requests_validate', methods: ['POST'])]
    public function validate(
        Request $request,
        TeacherRequest $teacherRequest,
        TeacherRequestRepository $teacherRequestRepository,
        UserRepository $userRepository
    ): Response {
        if ($this->isCsrfTokenValid('validate'.$teacherRequest->getId(), $request->request->get('_token'))) {
            $existingUser = $userRepository->findOneByEmail($teacherRequest->getEmail());

            if (null === $existingUser) {
                $user = new User();
                $user->setFirstname($teacherRequest->getFirstname());
                $user->setLastname($teacherRequest->getLastname());
                $user->setEmail($teacherRequest->getEmail());
                $user->setDescription($teacherRequest->getDescription());
                $user->setPassword($teacherRequest->getPassword());
                $user->setPhoto($teacherRequest->getPhoto());
                $user->setRoles([User::ROLE_TEACHER]);

                $teacherRequest->setPhoto(null);
                
                $userRepository->add($user);
                $teacherRequestRepository->remove($teacherRequest);

                $this->addFlash('success', 'La demande a bien été validée.');
            } else {
                $this->addFlash('error', 'La demande ne peut pas être validée, un compte utilisateur existe déjà avec cette adresse email.');
            }
        }

        return $this->redirectToRoute('backend_teacher_requests', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/image/{fileId}', name: 'backend_teacher_requests_delete_image', methods: ['DELETE'])]
    public function deleteImage(
        Request $request,
        TeacherRequestRepository $teacherRequestRepository,
        FileRepository $fileRepository,
        int $id,
        int $fileId
    ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $teacherRequest = $teacherRequestRepository->find($id);
        $file = $fileRepository->find($fileId);

        if ($this->isCsrfTokenValid('delete'.$file->getId(), $data['_token'])) {
            unlink($this->getParameter('uploads_directory').'/'.$file->getName());

            if (null !== $teacherRequest->getPhoto() && $teacherRequest->getPhoto()->getId() === $file->getId()) {
                $teacherRequest->setPhoto(null);
            }

            $fileRepository->remove($file);

            return new JsonResponse(['success' => true]);
        } else {
            return new JsonResponse(['success' => false], 400);
        }
    }
}
