<?php

namespace App\DataFixtures;

namespace App\DataFixtures;

use App\Entity\File;
use App\Entity\TeacherRequest;
use App\Entity\Training;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $this->addUsers($manager);
        $this->addTeacherRequests($manager);
        $this->addTrainings($manager);

        $manager->flush();
    }

    public function addUsers(ObjectManager $manager): void
    {
        $user = new User();
        $user->setFirstname('Patrick');
        $user->setLastname('Barros');
        $user->setUsername('patpat');
        $user->setEmail('patrick.barros@ecoweb.com');
        $hashedPassword = $this->passwordHasher->hashPassword($user, 'patpat');
        $user->setPassword($hashedPassword);
        $user->setRoles([
            User::ROLE_ADMIN
        ]);
        $manager->persist($user);

        $user2 = new User();
        $user2->setFirstname('Jonathan');
        $user2->setLastname('Pierrot');
        $user2->setUsername('joejoe');
        $user2->setEmail('jonathan.pierrot@ecoweb.com');
        $hashedPassword = $this->passwordHasher->hashPassword($user2, 'joejoe');
        $user2->setPassword($hashedPassword);
        $user2->setRoles([
            User::ROLE_TEACHER
        ]);
        $manager->persist($user2);

        $user3 = new User();
        $user3->setUsername('isabelledu75');
        $user3->setEmail('isabelle.durand@yahoo.fr');
        $hashedPassword = $this->passwordHasher->hashPassword($user3, 'isabelledu75');
        $user3->setPassword($hashedPassword);
        $manager->persist($user3);

        $manager->flush();
    }

    public function addTeacherRequests(ObjectManager $manager): void
    {
        $photo = new File();
        $photo->setName('photo_thomas_carpentier.jpg');
        $photo->setExtension('jpg');
        $manager->persist($photo);

        $teacherRequest = new TeacherRequest();
        $teacherRequest->setFirstname('Thomas');
        $teacherRequest->setLastname('Carpentier');
        $teacherRequest->setDescription('Je suis un homme sérieux et motivé, et j\'adore enseigner des choses.');
        $teacherRequest->setPhoto($photo);
        $teacherRequest->setEmail('thomas.carpentier@ecoweb.com');
        $hashedPassword = $this->passwordHasher->hashPassword($teacherRequest, 'toto');
        $teacherRequest->setPassword($hashedPassword);
        $manager->persist($teacherRequest);
    }

    public function addTrainings(ObjectManager $manager): void
    {
        $image = new File();
        $image->setName('parcours_utilisateurs.jpg');
        $image->setExtension('jpg');
        $manager->persist($image);

        $image2 = new File();
        $image2->setName('green_it.jpg');
        $image2->setExtension('jpg');
        $manager->persist($image2);

        $training = new Training();
        $training->setTitle('Parcours utilisateurs');
        $training->setDescription('Des parcours utilisateurs plus simples, sont des parcours qui consomment moins de ressources énergétiques');
        $training->setImage($image);
        $manager->persist($training);

        $training2 = new Training();
        $training2->setTitle('Le Green IT');
        $training2->setDescription('Découvrez tout sur le Green IT : l’informatique verte et durable');
        $training2->setImage($image2);
        $manager->persist($training2);
    }
}