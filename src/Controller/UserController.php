<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\User;
use App\Form\Backend\UserType;
use App\Repository\FileRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/utilisateurs')]
class UserController extends AbstractController
{
    #[Route('/', name: 'backend_users', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('backend/user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/nouveau', name: 'backend_users_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserPasswordHasherInterface $passwordHasher, FileRepository $fileRepository, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();

            if (!empty($plainPassword)) {
                $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
                $user->setPassword($hashedPassword);
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

                $user->setPhoto($photo);
            }

            $userRepository->add($user);
            return $this->redirectToRoute('backend_users', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'backend_users_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('backend/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edition', name: 'backend_users_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserPasswordHasherInterface $passwordHasher, FileRepository $fileRepository, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();

            if (!empty($plainPassword)) {
                $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
                $user->setPassword($hashedPassword);
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

                $user->setPhoto($photo);
            }

            $userRepository->add($user);
            return $this->redirectToRoute('backend_users', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'backend_users_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user);
        }

        return $this->redirectToRoute('backend_users', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/image/{fileId}', name: 'backend_users_delete_image', methods: ['DELETE'])]
    public function deleteImage(
        Request $request,
        UserRepository $userRepository,
        FileRepository $fileRepository,
        int $id,
        int $fileId
    ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $user = $userRepository->find($id);
        $file = $fileRepository->find($fileId);

        if ($this->isCsrfTokenValid('delete'.$file->getId(), $data['_token'])) {
            unlink($this->getParameter('uploads_directory').'/'.$file->getName());

            if (null !== $user->getPhoto() && $user->getPhoto()->getId() === $file->getId()) {
                $user->setPhoto(null);
            }

            $fileRepository->remove($file);

            return new JsonResponse(['success' => true]);
        } else {
            return new JsonResponse(['success' => false], 400);
        }
    }
}
