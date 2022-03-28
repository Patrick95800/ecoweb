<?php

namespace App\DataFixtures;

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\File;
use App\Entity\Question;
use App\Entity\Quizz;
use App\Entity\TeacherRequest;
use App\Entity\Training;
use App\Entity\TrainingSection;
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
        $this->addTrainingSections($manager);
        $this->addQuizzes($manager);

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

        $manager->flush();
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
        $training->setSlug('parcours-utilisateurs');
        $training->setDescription('Des parcours utilisateurs plus simples, sont des parcours qui consomment moins de ressources énergétiques');
        $training->setImage($image);
        $manager->persist($training);

        $training2 = new Training();
        $training2->setTitle('Le Green IT');
        $training2->setSlug('le-green-it');
        $training2->setDescription('Découvrez tout sur le Green IT : l’informatique verte et durable');
        $training2->setImage($image2);
        $manager->persist($training2);

        $manager->flush();
    }

    public function addTrainingSections(ObjectManager $manager): void
    {
        $training = $manager->getRepository(Training::class)->findOneByTitle('Parcours utilisateurs');
        $training2 = $manager->getRepository(Training::class)->findOneByTitle('Le Green IT');

        $trainingSection = new TrainingSection();
        $trainingSection->setTitle('Green IT : définition');
        $trainingSection->setSlug('green-it-definition');
        $trainingSection->setTraining($training2);
        $manager->persist($trainingSection);
        $training2->addSection($trainingSection);

        $trainingSection2 = new TrainingSection();
        $trainingSection2->setTitle('Les dimensions sociales et sociétales du Green IT');
        $trainingSection2->setSlug('les-dimensions-sociales-et-societales-du-green-it');
        $trainingSection2->setTraining($training2);
        $manager->persist($trainingSection2);
        $training2->addSection($trainingSection2);

        $trainingSection3 = new TrainingSection();
        $trainingSection3->setTitle('Qu\'est-ce qu\'un parcours utilisateur UX ?');
        $trainingSection3->setSlug('quest-ce-quun-parcours-utilisateur-ux');
        $trainingSection3->setTraining($training);
        $manager->persist($trainingSection3);
        $training->addSection($trainingSection3);

        $trainingSection4 = new TrainingSection();
        $trainingSection4->setTitle('Pourquoi analyser les problèmes d\'un parcours d\'utilisateur aide à améliorer l’UX ?');
        $trainingSection4->setSlug('pourquoi-analyser-problemes-parcours-utilisateur-aide-amelioration-ux');
        $trainingSection4->setTraining($training);
        $manager->persist($trainingSection4);
        $training->addSection($trainingSection4);

        $trainingSection5 = new TrainingSection();
        $trainingSection5->setTitle('Le processus en 8 étapes pour créer une expérience utilisateur (UX) performante !');
        $trainingSection5->setSlug('le-processus-8-etapes-pour-creer-une-experience-ux-performante');
        $trainingSection5->setTraining($training);
        $manager->persist($trainingSection5);
        $training->addSection($trainingSection5);

        $manager->flush();
    }

    public function addQuizzes(ObjectManager $manager): void
    {
        $trainingSection = $manager->getRepository(TrainingSection::class)->findOneByTitle('Qu\'est-ce qu\'un parcours utilisateur UX ?');

        $quizz = new Quizz();
        $quizz->setTrainingSection($trainingSection);
        $manager->persist($quizz);
        $trainingSection->setQuizz($quizz);

        $question = new Question();
        $question->setTitle('Que veut dire le terme UX ?');
        $manager->persist($question);

        $answer = new Answer();
        $answer->setText('Ultra Xtra');
        $answer->setQuestion($question);
        $manager->persist($answer);
        $question->addAnswer($answer);

        $answer2 = new Answer();
        $answer2->setText('User Experience');
        $answer2->setQuestion($question);
        $answer2->setIsAnswer(true);
        $manager->persist($answer2);
        $question->addAnswer($answer2);

        $question2 = new Question();
        $question2->setTitle('Que favorise l\'UX ?');
        $manager->persist($question2);

        $answer3 = new Answer();
        $answer3->setText('Une approche plus centrée sur l\'utilisateur');
        $answer3->setQuestion($question2);
        $answer3->setIsAnswer(true);
        $manager->persist($answer3);
        $question2->addAnswer($answer3);

        $answer4 = new Answer();
        $answer4->setText('Pas grand chose');
        $answer4->setQuestion($question2);
        $manager->persist($answer4);
        $question2->addAnswer($answer4);

        $quizz->addQuestion($question);
        $quizz->addQuestion($question2);

        $manager->flush();
    }
}