<?php

namespace App\DataFixtures;

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\File;
use App\Entity\Question;
use App\Entity\Quizz;
use App\Entity\TeacherRequest;
use App\Entity\Training;
use App\Entity\TrainingLesson;
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
        $this->addTrainingLessons($manager);
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
        $image->setName('fixtures/parcours_utilisateurs.jpg');
        $image->setExtension('jpg');
        $manager->persist($image);

        $image2 = new File();
        $image2->setName('fixtures/green_it.jpg');
        $image2->setExtension('jpg');
        $manager->persist($image2);

        $image3 = new File();
        $image3->setName('fixtures/greenmetrics.jpg');
        $image3->setExtension('jpg');
        $manager->persist($image3);

        $image4 = new File();
        $image4->setName('fixtures/pollution_net.jpg');
        $image4->setExtension('jpg');
        $manager->persist($image4);

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

        $training3 = new Training();
        $training3->setTitle('Utiliser les Greenmetrics');
        $training3->setSlug('greenmetrics');
        $training3->setDescription('Adoptez les bons réflexes avec Greenmetrics pour minimiser votre bilan carbone numérique');
        $training3->setImage($image3);
        $manager->persist($training3);

        $training4 = new Training();
        $training4->setTitle('La pollution émise par internet');
        $training4->setSlug('pollution-internet');
        $training4->setDescription('Si Internet était un pays, il serait le 3ème plus gros consommateur d’électricité au monde.');
        $training4->setImage($image4);
        $manager->persist($training4);

        $manager->flush();
    }

    public function addTrainingSections(ObjectManager $manager): void
    {
        $training = $manager->getRepository(Training::class)->findOneByTitle('Parcours utilisateurs');
        $training2 = $manager->getRepository(Training::class)->findOneByTitle('Le Green IT');
        $training3 = $manager->getRepository(Training::class)->findOneByTitle('Utiliser les Greenmetrics');
        $training4 = $manager->getRepository(Training::class)->findOneByTitle('La pollution émise par internet');

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

        $trainingSection6 = new TrainingSection();
        $trainingSection6->setTitle('Identifiez les sources de pollution numérique');
        $trainingSection6->setSlug('sources-pollution-numérique');
        $trainingSection6->setTraining($training3);
        $manager->persist($trainingSection6);
        $training3->addSection($trainingSection6);

        $trainingSection7 = new TrainingSection();
        $trainingSection7->setTitle('Améliorez votre référencement');
        $trainingSection7->setSlug('ameliorer-referencement');
        $trainingSection7->setTraining($training3);
        $manager->persist($trainingSection7);
        $training3->addSection($trainingSection7);

        $trainingSection8 = new TrainingSection();
        $trainingSection8->setTitle('Communiquez sur la réduction de votre impact environnemental.');
        $trainingSection8->setSlug('communiquer-reduction-impact');
        $trainingSection8->setTraining($training3);
        $manager->persist($trainingSection8);
        $training3->addSection($trainingSection8);

        $trainingSection9 = new TrainingSection();
        $trainingSection9->setTitle('L’impact environnemental des data centers');
        $trainingSection9->setSlug('impact-data-centers');
        $trainingSection9->setTraining($training4);
        $manager->persist($trainingSection9);
        $training4->addSection($trainingSection9);

        $trainingSection10 = new TrainingSection();
        $trainingSection10->setTitle('Les données sur internet');
        $trainingSection10->setSlug('donnees-internet');
        $trainingSection10->setTraining($training4);
        $manager->persist($trainingSection10);
        $training4->addSection($trainingSection10);

        $trainingSection11 = new TrainingSection();
        $trainingSection11->setTitle('Energie renouvelable');
        $trainingSection11->setSlug('energie-renouvelable');
        $trainingSection11->setTraining($training4);
        $manager->persist($trainingSection11);
        $training4->addSection($trainingSection11);

        $manager->flush();
    }

    public function addTrainingLessons(ObjectManager $manager): void
    {
        $trainingSection = $manager->getRepository(TrainingSection::class)->findOneByTitle('L’impact environnemental des data centers');
        $trainingSection2 = $manager->getRepository(TrainingSection::class)->findOneByTitle('Les données sur internet');
        $trainingSection3 = $manager->getRepository(TrainingSection::class)->findOneByTitle('Energie renouvelable');

        $trainingLesson = new TrainingLesson();
        $trainingLesson->setTitle('Qu\'est-ce q\'un data center ?');
        $trainingLesson->setExplanation('Un centre de données, ou centre informatique est un lieu où sont regroupés les équipements constituants d\'un système d\'information. Ce regroupement permet de faciliter la sécurisation, la gestion et la maintenance des équipements et des données stockées.');
        $trainingLesson->setVideo('<iframe width="560" height="315" src="https://www.youtube.com/embed/rO6bXt7d2L8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
        $trainingLesson->setTrainingSection($trainingSection);
        $manager->persist($trainingLesson);
        $trainingSection->addLesson($trainingLesson);

        $trainingLesson2 = new TrainingLesson();
        $trainingLesson2->setTitle('Quel est le rôle d\'un datacenter ?');
        $trainingLesson2->setExplanation('Les centres de données servent à héberger les milliards de milliards de gigaoctets présents sur internet, mais aussi les données que toute personne ou compagnie génèrent et utilisent');
        $trainingLesson2->setVideo('<iframe width="560" height="315" src="https://www.youtube.com/embed/lnvSFDQFPAs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
        $trainingLesson2->setTrainingSection($trainingSection);
        $manager->persist($trainingLesson2);
        $trainingSection->addLesson($trainingLesson2);

        $trainingLesson3 = new TrainingLesson();
        $trainingLesson3->setTitle('Qu\'est-ce qui consomme le plus dans un datacenter ?');
        $trainingLesson3->setExplanation('La climatisation et les systèmes de refroidissement représentent de 40 à 50 % de la consommation énergétique des data centers (Gimelec).');
        $trainingLesson3->setVideo('<iframe width="560" height="315" src="https://www.youtube.com/embed/hfPalDrX6Jw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
        $trainingLesson3->setTrainingSection($trainingSection);
        $manager->persist($trainingLesson3);
        $trainingSection->addLesson($trainingLesson3);

        $trainingLesson4 = new TrainingLesson();
        $trainingLesson4->setTitle('Les emails');
        $trainingLesson4->setExplanation('Un mail représente 4 g d\'équivalent CO2 (émissions liées au fonctionnement de l\'ordinateur et des serveurs, ainsi qu\'à une partie de leur fabrication). 65 mails émettent ainsi autant qu\'un kilomètre en voiture. Un mail avec une pièce jointe volumineuse peut atteindre 50 g. Un spam non lu coûte à la planète 0,3 g.');
        $trainingLesson4->setVideo('<iframe width="560" height="315" src="https://www.youtube.com/embed/JvwiMNcg9sw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
        $trainingLesson4->setTrainingSection($trainingSection2);
        $manager->persist($trainingLesson4);
        $trainingSection2->addLesson($trainingLesson4);

        $trainingLesson5 = new TrainingLesson();
        $trainingLesson5->setTitle('Recherche Google');
        $trainingLesson5->setExplanation('Une recherche Google = 5 à 7 grammes de Co2. Il y a 180 milliards de recherches effectuées par heures sur Google, cela équivaut à 16 kilos de Co2 émis chaque seconde.');
        $trainingLesson5->setVideo('<iframe width="560" height="315" src="https://www.youtube.com/embed/-YJaspyc9Xo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
        $trainingLesson5->setTrainingSection($trainingSection2);
        $manager->persist($trainingLesson5);
        $trainingSection2->addLesson($trainingLesson5);

        $trainingLesson6 = new TrainingLesson();
        $trainingLesson6->setTitle('Le Cloud');
        $trainingLesson6->setExplanation('Le développement exponentiel du cloud computing génère un impact énorme sur la consommation mondiale d\'électricité et génère lui aussi du dioxyde de carbone : ce secteur pourrait, d\'ici 2025, consommer 20% de l\'électricité mondiale et émettre 5% de CO2 selon une récente étude suédoise.');
        $trainingLesson6->setVideo('<iframe width="560" height="315" src="https://www.youtube.com/embed/iiHxCX76bYU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
        $trainingLesson6->setTrainingSection($trainingSection2);
        $manager->persist($trainingLesson6);
        $trainingSection2->addLesson($trainingLesson6);

        $trainingLesson7 = new TrainingLesson();
        $trainingLesson7->setTitle('Les promesses des GAFA');
        $trainingLesson7->setExplanation('Heureusement, les GAFA n\’ont pas attendu les dernières mises en garde du GIEC pour se mettre au vert. Alors que les experts climat de l’ONU en ont remis une couche ce lundi dans un rapport de 400 pages sur l\'urgence de l\'action pour lutter contre le réchauffement climatique, les géants de la tech ont déjà pris le virage écologique depuis plusieurs années');
        $trainingLesson7->setVideo('<iframe width="560" height="315" src="https://www.youtube.com/embed/DpYv9lOHYbY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
        $trainingLesson7->setTrainingSection($trainingSection3);
        $manager->persist($trainingLesson7);
        $trainingSection3->addLesson($trainingLesson7);

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