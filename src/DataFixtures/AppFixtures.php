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

    //-----------------------------------------------------
    // addUsers
    //-----------------------------------------------------
    public function addUsers(ObjectManager $manager): void
    {
        /* Admin */
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

        /* Formateur */
        $user2 = new User();
        $user2->setFirstname('Jonathan');
        $user2->setLastname('Pierrot');
        $user2->setUsername('jonath');
        $user2->setEmail('jonathan.pierrot@ecoweb.com');
        $hashedPassword = $this->passwordHasher->hashPassword($user2, 'jonjon');
        $user2->setPassword($hashedPassword);
        $user2->setRoles([
            User::ROLE_TEACHER
        ]);
        $manager->persist($user2);

        /* Apprenant */
        $user3 = new User();
        $user3->setUsername('isabelledu75');
        $user3->setEmail('isabelle.durand@yahoo.fr');
        $hashedPassword = $this->passwordHasher->hashPassword($user3, 'isaisa');
        $user3->setPassword($hashedPassword);
        $manager->persist($user3);

        /* Formateur */
        $user4 = new User();
        $user4->setFirstname('Marie');
        $user4->setLastname('Duval');
        $user4->setUsername('mariedudu');
        $user4->setEmail('marie.duval@ecoweb.com');
        $hashedPassword = $this->passwordHasher->hashPassword($user4, 'marmar');
        $user4->setPassword($hashedPassword);
        $user4->setRoles([
            User::ROLE_TEACHER
        ]);
        $manager->persist($user4);

        /* Apprenant */
        $user5 = new User();
        $user5->setUsername('mathdu95');
        $user5->setEmail('mathieu.ollivier@laposte.net');
        $hashedPassword = $this->passwordHasher->hashPassword($user5, 'matmat');
        $user5->setPassword($hashedPassword);
        $manager->persist($user5);

        $manager->flush();
    }

    //-----------------------------------------------------
    // addTeacherRequests
    //-----------------------------------------------------
    public function addTeacherRequests(ObjectManager $manager): void
    {
        /* Photo Thomas */
        $photo = new File();
        $photo->setName('photo_thomas_carpentier.jpg');
        $photo->setExtension('jpg');
        $manager->persist($photo);

        /* Candidature Thomas */
        $teacherRequest = new TeacherRequest();
        $teacherRequest->setFirstname('Thomas');
        $teacherRequest->setLastname('Carpentier');
        $teacherRequest->setDescription('Je suis un homme sérieux et motivé, et j\'adore enseigner des choses.');
        $teacherRequest->setPhoto($photo);
        $teacherRequest->setEmail('thomas.carpentier@prof.com');
        $hashedPassword = $this->passwordHasher->hashPassword($teacherRequest, 'thotho');
        $teacherRequest->setPassword($hashedPassword);
        $manager->persist($teacherRequest);

        /* Photo Elodie */
        $photo2 = new File();
        $photo2->setName('photo_elodie_granger.jpg');
        $photo2->setExtension('jpg');
        $manager->persist($photo2);

        /* Candidature Elodie */
        $teacherRequest2 = new TeacherRequest();
        $teacherRequest2->setFirstname('Elodie');
        $teacherRequest2->setLastname('Granger');
        $teacherRequest2->setDescription('Ancienne professeure des écoles, j\'aimerais allier mes compétences à mon egagement pour un monde plus responsable.');
        $teacherRequest2->setPhoto($photo2);
        $teacherRequest2->setEmail('elodie.granger@nature.com');
        $hashedPassword = $this->passwordHasher->hashPassword($teacherRequest2, 'eloelo');
        $teacherRequest2->setPassword($hashedPassword);
        $manager->persist($teacherRequest2);

        $manager->flush();
    }

    //-----------------------------------------------------
    // addTrainings
    //-----------------------------------------------------
    public function addTrainings(ObjectManager $manager): void
    {

        /* Image parcours utilisateur */
        $image = new File();
        $image->setName('fixtures/parcours_utilisateurs.jpg');
        $image->setExtension('jpg');
        $manager->persist($image);

        /* Image Green IT */
        $image2 = new File();
        $image2->setName('fixtures/green_it.jpg');
        $image2->setExtension('jpg');
        $manager->persist($image2);

        /* Image Greenmetrics */
        $image3 = new File();
        $image3->setName('fixtures/greenmetrics.jpg');
        $image3->setExtension('jpg');
        $manager->persist($image3);

        /* Image Pollution internet */
        $image4 = new File();
        $image4->setName('fixtures/pollution_net.jpg');
        $image4->setExtension('jpg');
        $manager->persist($image4);

        /* Training parcours utilisateur */
        $training = new Training();
        $training->setTitle('Parcours utilisateurs');
        $training->setSlug('parcours-utilisateurs');
        $training->setDescription('Des parcours utilisateurs plus simples, sont des parcours qui consomment moins de ressources énergétiques');
        $training->setImage($image);
        $manager->persist($training);

        /* Training Green ITr */
        $training2 = new Training();
        $training2->setTitle('Le Green IT');
        $training2->setSlug('le-green-it');
        $training2->setDescription('Découvrez tout sur le Green IT : l’informatique verte et durable');
        $training2->setImage($image2);
        $manager->persist($training2);

        /* Training Greensmetrics */
        $training3 = new Training();
        $training3->setTitle('Utiliser les Greenmetrics');
        $training3->setSlug('greenmetrics');
        $training3->setDescription('Adoptez les bons réflexes avec Greenmetrics pour minimiser votre bilan carbone numérique');
        $training3->setImage($image3);
        $manager->persist($training3);

        /* Training pollution internet */
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

        /* TrainingSection Green IT  1 */
        $trainingSection = new TrainingSection();
        $trainingSection->setTitle('Green IT : définition');
        $trainingSection->setSlug('green-it-definition');
        $trainingSection->setTraining($training2);
        $manager->persist($trainingSection);
        $training2->addSection($trainingSection);

        /* TrainingSection Green IT  2 */
        $trainingSection2 = new TrainingSection();
        $trainingSection2->setTitle('Les dimensions sociales et sociétales du Green IT');
        $trainingSection2->setSlug('les-dimensions-sociales-et-societales-du-green-it');
        $trainingSection2->setTraining($training2);
        $manager->persist($trainingSection2);
        $training2->addSection($trainingSection2);

        /* TrainingSection parcours utilisateur  1 */
        $trainingSection3 = new TrainingSection();
        $trainingSection3->setTitle('Qu\'est-ce qu\'un parcours utilisateur UX ?');
        $trainingSection3->setSlug('quest-ce-quun-parcours-utilisateur-ux');
        $trainingSection3->setTraining($training);
        $manager->persist($trainingSection3);
        $training->addSection($trainingSection3);

        /* TrainingSection parcours utilisateur  2 */
        $trainingSection4 = new TrainingSection();
        $trainingSection4->setTitle('Pourquoi analyser les problèmes d\'un parcours d\'utilisateur aide à améliorer l’UX ?');
        $trainingSection4->setSlug('pourquoi-analyser-problemes-parcours-utilisateur-aide-amelioration-ux');
        $trainingSection4->setTraining($training);
        $manager->persist($trainingSection4);
        $training->addSection($trainingSection4);

        /* TrainingSection parcours utilisateur  3 */
        $trainingSection5 = new TrainingSection();
        $trainingSection5->setTitle('Le processus en 8 étapes pour créer une expérience utilisateur (UX) performante !');
        $trainingSection5->setSlug('le-processus-8-etapes-pour-creer-une-experience-ux-performante');
        $trainingSection5->setTraining($training);
        $manager->persist($trainingSection5);
        $training->addSection($trainingSection5);

        /* TrainingSection Parcours utilisateur 1 */
        $trainingSection6 = new TrainingSection();
        $trainingSection6->setTitle('Identifiez les sources de pollution numérique');
        $trainingSection6->setSlug('sources-pollution-numérique');
        $trainingSection6->setTraining($training3);
        $manager->persist($trainingSection6);
        $training3->addSection($trainingSection6);

        /* TrainingSection Parcours utilisateur  2 */
        $trainingSection7 = new TrainingSection();
        $trainingSection7->setTitle('Améliorez votre référencement');
        $trainingSection7->setSlug('ameliorer-referencement');
        $trainingSection7->setTraining($training3);
        $manager->persist($trainingSection7);
        $training3->addSection($trainingSection7);

        /* TrainingSection Parcours utilisateur 3 */
        $trainingSection8 = new TrainingSection();
        $trainingSection8->setTitle('Communiquez sur la réduction de votre impact environnemental.');
        $trainingSection8->setSlug('communiquer-reduction-impact');
        $trainingSection8->setTraining($training3);
        $manager->persist($trainingSection8);
        $training3->addSection($trainingSection8);

        /* TrainingSection Pollution Internet  1 */
        $trainingSection9 = new TrainingSection();
        $trainingSection9->setTitle('L\'impact environnemental des data centers');
        $trainingSection9->setSlug('impact-data-centers');
        $trainingSection9->setTraining($training4);
        $manager->persist($trainingSection9);
        $training4->addSection($trainingSection9);

        /* TrainingSection Pollution Internet  2 */
        $trainingSection10 = new TrainingSection();
        $trainingSection10->setTitle('Les données sur internet');
        $trainingSection10->setSlug('donnees-internet');
        $trainingSection10->setTraining($training4);
        $manager->persist($trainingSection10);
        $training4->addSection($trainingSection10);

        /* TrainingSection Pollution Internet  3 */
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
        $trainingSection = $manager->getRepository(TrainingSection::class)->findOneByTitle('L\'impact environnemental des data centers');
        $trainingSection2 = $manager->getRepository(TrainingSection::class)->findOneByTitle('Les données sur internet');
        $trainingSection3 = $manager->getRepository(TrainingSection::class)->findOneByTitle('Energie renouvelable');

        /* TrainingSectionLesson Pollution Internet  1.1 */
        $trainingLesson = new TrainingLesson();
        $trainingLesson->setTitle('Qu\'est-ce qu\'un data center ?');
        $trainingLesson->setExplanation('Un centre de données, ou centre informatique est un lieu où sont regroupés les équipements constituants d\'un système d\'information. Ce regroupement permet de faciliter la sécurisation, la gestion et la maintenance des équipements et des données stockées.');
        $trainingLesson->setVideo('<iframe width="560" height="315" src="https://www.youtube.com/embed/rO6bXt7d2L8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
        $trainingLesson->setTrainingSection($trainingSection);
        $manager->persist($trainingLesson);
        $trainingSection->addLesson($trainingLesson);

        /* TrainingSectionLesson Pollution Internet  1.2 */
        $trainingLesson2 = new TrainingLesson();
        $trainingLesson2->setTitle('Quel est le rôle d\'un datacenter ?');
        $trainingLesson2->setExplanation('Les centres de données servent à héberger les milliards de milliards de gigaoctets présents sur internet, mais aussi les données que toute personne ou compagnie génèrent et utilisent.');
        $trainingLesson2->setVideo('<iframe width="560" height="315" src="https://www.youtube.com/embed/lnvSFDQFPAs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
        $trainingLesson2->setTrainingSection($trainingSection);
        $manager->persist($trainingLesson2);
        $trainingSection->addLesson($trainingLesson2);

        /* TrainingSectionLesson Pollution Internet  1.3 */
        $trainingLesson3 = new TrainingLesson();
        $trainingLesson3->setTitle('Qu\'est-ce qui consomme le plus dans un datacenter ?');
        $trainingLesson3->setExplanation('La climatisation et les systèmes de refroidissement représentent envrion 40% de la consommation énergétique des data centers (Gimelec).');
        $trainingLesson3->setVideo('<iframe width="560" height="315" src="https://www.youtube.com/embed/hfPalDrX6Jw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
        $trainingLesson3->setTrainingSection($trainingSection);
        $manager->persist($trainingLesson3);
        $trainingSection->addLesson($trainingLesson3);

        /* TrainingSectionLesson Pollution Internet  2.1 */
        $trainingLesson4 = new TrainingLesson();
        $trainingLesson4->setTitle('Les emails');
        $trainingLesson4->setExplanation('Un mail représente 4 g d\'équivalent CO2 (émissions liées au fonctionnement de l\'ordinateur et des serveurs, ainsi qu\'à une partie de leur fabrication). 65 mails émettent ainsi autant qu\'un kilomètre en voiture. Un mail avec une pièce jointe volumineuse peut atteindre 50 g. Un spam non lu coûte à la planète 0,3 g.');
        $trainingLesson4->setVideo('<iframe width="560" height="315" src="https://www.youtube.com/embed/JvwiMNcg9sw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
        $trainingLesson4->setTrainingSection($trainingSection2);
        $manager->persist($trainingLesson4);
        $trainingSection2->addLesson($trainingLesson4);

        /* TrainingSectionLesson Pollution Internet  2.2 */
        $trainingLesson5 = new TrainingLesson();
        $trainingLesson5->setTitle('Recherche Google');
        $trainingLesson5->setExplanation('Une recherche Google = 5 à 7 grammes de Co2. Il y a 180 milliards de recherches effectuées par heures sur Google, cela équivaut à 16 kilos de Co2 émis chaque seconde.');
        $trainingLesson5->setVideo('<iframe width="560" height="315" src="https://www.youtube.com/embed/-YJaspyc9Xo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
        $trainingLesson5->setTrainingSection($trainingSection2);
        $manager->persist($trainingLesson5);
        $trainingSection2->addLesson($trainingLesson5);

        /* TrainingSectionLesson Pollution Internet  2.3 */
        $trainingLesson6 = new TrainingLesson();
        $trainingLesson6->setTitle('Le Cloud');
        $trainingLesson6->setExplanation('Le développement exponentiel du cloud computing génère un impact énorme sur la consommation mondiale d\'électricité et génère lui aussi du dioxyde de carbone : ce secteur pourrait, d\'ici 2025, consommer 20% de l\'électricité mondiale et émettre 5% de CO2 selon une récente étude suédoise.');
        $trainingLesson6->setVideo('<iframe width="560" height="315" src="https://www.youtube.com/embed/iiHxCX76bYU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
        $trainingLesson6->setTrainingSection($trainingSection2);
        $manager->persist($trainingLesson6);
        $trainingSection2->addLesson($trainingLesson6);

        /* TrainingSectionLesson Pollution Internet  3.1 */
        $trainingLesson7 = new TrainingLesson();
        $trainingLesson7->setTitle('Les promesses des GAFA');
        $trainingLesson7->setExplanation('Heureusement, les GAFA n\'ont pas attendu les dernières mises en garde du GIEC pour se mettre au vert. Alors que les experts climat de l’ONU en ont remis une couche ce lundi dans un rapport de 400 pages sur l\'urgence de l\'action pour lutter contre le réchauffement climatique, les géants de la tech ont déjà pris le virage écologique depuis plusieurs années');
        $trainingLesson7->setVideo('<iframe width="560" height="315" src="https://www.youtube.com/embed/DpYv9lOHYbY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
        $trainingLesson7->setTrainingSection($trainingSection3);
        $manager->persist($trainingLesson7);
        $trainingSection3->addLesson($trainingLesson7);

        $manager->flush();
    }


    public function addQuizzes(ObjectManager $manager): void
    {
        /* Quizz parcours utilisateur */
        $trainingSection = $manager->getRepository(TrainingSection::class)->findOneByTitle('Qu\'est-ce qu\'un parcours utilisateur UX ?');

        $quizz = new Quizz();
        $quizz->setTrainingSection($trainingSection);
        $manager->persist($quizz);
        $trainingSection->setQuizz($quizz);

        $question = new Question();
        $question->setTitle('Que veut dire le terme UX ?');
        $question->setExplanation('U comme User, et E comme Experience');
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
        $question->setExplanation('On met l\'utilisateur au centre du projet' );
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

        /* Quizz Pollution Internet - Impact environnemental */
        $trainingSection2 = $manager->getRepository(TrainingSection::class)->findOneByTitle('L\'impact environnemental des data centers');

        /* Quizz Pollution Internet - Impact environnemental */
        $quizz2 = new Quizz();
        $quizz2->setTrainingSection($trainingSection2);
        $manager->persist($quizz2);
        $trainingSection2->setQuizz($quizz2);

        /* Quizz Pollution Internet - Impact environnemental - Q1 */
        $question3 = new Question();
        $question3->setTitle('Que veut dire datacenter en français ?');
        $question3->setExplanation('Il faut traduire littérallement. C\'est un centre de données.');
        $manager->persist($question3);

        /* Quizz Pollution Internet - Impact environnemental - Q1 R1*/
        $answer5 = new Answer();
        $answer5->setText('Centre de RDV galant');
        $answer5->setQuestion($question3);
        $manager->persist($answer5);
        $question3->addAnswer($answer5);

        /* Quizz Pollution Internet - Impact environnemental - Q1 R2 */
        $answer6 = new Answer();
        $answer6->setText('Centre de données');
        $answer6->setQuestion($question3);
        $answer6->setIsAnswer(true);
        $manager->persist($answer6);
        $question3->addAnswer($answer6);

        /* Quizz Pollution Internet - Impact environnemental - Q1 R3 */
        $answer7 = new Answer();
        $answer7->setText('Centre de datation');
        $answer7->setQuestion($question3);
        $manager->persist($answer7);
        $question3->addAnswer($answer7);

        /* Quizz Pollution Internet - Impact environnemental - Q1 R4 */
        $answer8 = new Answer();
        $answer8->setText('Centre commercial');
        $answer8->setQuestion($question3);
        $manager->persist($answer8);
        $question3->addAnswer($answer8);

        /* Quizz Pollution Internet - Role datacenter - Q2 */
        $question4 = new Question();
        $question4->setTitle('À quoi sert un datacenter?');
        $question4->setExplanation('Un datcenter sert à herberger des données.');
        $manager->persist($question4);

        /* Quizz Pollution Internet - Role datacenter - Q2 R1 */
        $answer9 = new Answer();
        $answer9->setText('Assurer l\'alimentation des entreprises');
        $answer9->setQuestion($question4);
        $manager->persist($answer4);
        $question4->addAnswer($answer9);

        /* Quizz Pollution Internet - Role datacenter - Q2 R2 */
        $answer10 = new Answer();
        $answer10->setText('Héberger des données');
        $answer10->setQuestion($question4);
        $answer10->setIsAnswer(true);
        $manager->persist($answer10);
        $question4->addAnswer($answer10);

        /* Quizz Pollution Internet - Role datacenter - Q2 R3 */
        $answer11 = new Answer();
        $answer11->setText('Remplacer les ordinateurs');
        $answer11->setQuestion($question4);
        $manager->persist($answer11);
        $question4->addAnswer($answer11);

        /* Quizz Pollution Internet - Role datacenter - Q2 R4 */
        $answer12 = new Answer();
        $answer12->setText('Fabriquer des microprocesseur');
        $answer12->setQuestion($question4);
        $manager->persist($answer12);
        $question4->addAnswer($answer12);

        /* Quizz Pollution Internet - Conso énergétique - Q3 */
        $question5 = new Question();
        $question5->setTitle('Quel est la part des sysyèmes de refroissement dans la consommation énergétique des datacenters ?');
        $question5->setExplanation('La climatisation et les systèmes de refroidissement représentent de 40% de la consommation énergétique des datacenters.');
        $manager->persist($question5);

        /* Quizz Pollution Internet - Conso énergétique - Q3 R1 */
        $answer13 = new Answer();
        $answer13->setText('10%');
        $answer13->setQuestion($question5);
        $manager->persist($answer13);
        $question5->addAnswer($answer13);

        /* Quizz Pollution Internet - Conso énergétique - Q3 R2 */
        $answer14 = new Answer();
        $answer14->setText('20%');
        $answer14->setQuestion($question5);
        $manager->persist($answer14);
        $question5->addAnswer($answer14);

        /* Quizz Pollution Internet - Conso énergétique - Q3 R3 */
        $answer15 = new Answer();
        $answer15->setText('30%');
        $answer15->setQuestion($question5);
        $manager->persist($answer15);
        $question5->addAnswer($answer15);

        /* Quizz Pollution Internet - Conso énergétique - Q3 R4 */
        $answer16 = new Answer();
        $answer16->setText('40%');
        $answer16->setQuestion($question5);
        $answer16->setIsAnswer(true);
        $manager->persist($answer16);
        $question5->addAnswer($answer16);

        $quizz2->addQuestion($question3);
        $quizz2->addQuestion($question4);
        $quizz2->addQuestion($question5);

        /* Quizz Pollution Internet - Les données sur Internet */
        $trainingSection3 = $manager->getRepository(TrainingSection::class)->findOneByTitle('Les données sur internet');

        /* Quizz Pollution Internet - Les données sur Internet */
        $quizz3 = new Quizz();
        $quizz3->setTrainingSection($trainingSection3);
        $manager->persist($quizz3);
        $trainingSection3->setQuizz($quizz3);

        /* Quizz Pollution Internet - Emails - Q1 */
        $question6 = new Question();
        $question6->setTitle('L\'email est-il meilleur pour la planete qu\'une lettre ?');
        $question6->setExplanation('Non ! Si nous prenons en compte la totalité du cycle de vie d\'un email , l\'énergie consommée entre l\'émetteur et le récepteur d\'un email est impressionnante.');
        $manager->persist($question6);

        /* Quizz Pollution Internet - Emails - Q1 R1 */
        $answer17 = new Answer();
        $answer17->setText('Oui');
        $answer17->setQuestion($question6);
        $manager->persist($answer17);
        $question6->addAnswer($answer17);

        /* Quizz Pollution Internet - Les Emails - Q1 R2 */
        $answer18 = new Answer();
        $answer18->setText('Non');
        $answer18->setQuestion($question6);
        $answer18->setIsAnswer(true);
        $manager->persist($answer18);
        $question6->addAnswer($answer18);

        /* Quizz Pollution Internet - Google - Q2 */
        $question7 = new Question();
        $question7->setTitle('Chaque heure sur Google, combien de recherche sont éffectuées par les internautes ?');
        $question7->setExplanation('Il y a 180 milliards de recherches effectuées par heures sur Google, cela équivaut à 16 kilos de Co2 émis chaque seconde.');
        $manager->persist($question7);

        /* Quizz Pollution Internet - Google - Q2 R1 */
        $answer19 = new Answer();
        $answer19->setText('120 milliards');
        $answer19->setQuestion($question7);
        $manager->persist($answer19);
        $question7->addAnswer($answer19);

        /* Quizz Pollution Internet - Google - Q2 R2 */
        $answer20 = new Answer();
        $answer20->setText('150 milliards');
        $answer20->setQuestion($question7);
        $manager->persist($answer20);
        $question7->addAnswer($answer20);

        /* Quizz Pollution Internet - Google - Q2 R3 */
        $answer21 = new Answer();
        $answer21->setText('180 milliards');
        $answer21->setQuestion($question7);
        $answer21->setIsAnswer(true);
        $manager->persist($answer21);
        $question7->addAnswer($answer21);

        /* Quizz Pollution Internet - Google - Q2 R4 */
        $answer22 = new Answer();
        $answer22->setText('200 milliards');
        $answer22->setQuestion($question7);
        $manager->persist($answer22);
        $question7->addAnswer($answer22);

        /* Quizz Pollution Internet - Le cloud - Q3 */
        $question8 = new Question();
        $question8->setTitle('Dans quelle ville se trouve le plus grand centre de données de Suisse ?');
        $question8->setExplanation('Il se trouve dans la ville de Gland.');
        $manager->persist($question8);

        /* Quizz Pollution Internet - Cloud - Q3 R1 */
        $answer23 = new Answer();
        $answer23->setText('Noisette');
        $answer23->setQuestion($question8);
        $manager->persist($answer23);
        $question8->addAnswer($answer23);

        /* Quizz Pollution Internet - Cloud - Q3 R2 */
        $answer24 = new Answer();
        $answer24->setText('Gland');
        $answer24->setQuestion($question8);
        $answer24->setIsAnswer(true);
        $manager->persist($answer24);
        $question8->addAnswer($answer24);

        /* Quizz Pollution Internet - Cloud - Q3 R3 */
        $answer25 = new Answer();
        $answer25->setText('Amande');
        $answer25->setQuestion($question8);
        $manager->persist($answer25);
        $question8->addAnswer($answer25);

        /* Quizz Pollution Internet - Cloud - Q3 R4 */
        $answer26 = new Answer();
        $answer26->setText('Cajou');
        $answer26->setQuestion($question8);
        $manager->persist($answer26);
        $question8->addAnswer($answer26);

        $quizz3->addQuestion($question6);
        $quizz3->addQuestion($question7);
        $quizz3->addQuestion($question8);

        /* Quizz Pollution Internet - Energie renouvelable */
        $trainingSection4 = $manager->getRepository(TrainingSection::class)->findOneByTitle('Energie renouvelable');

        /* Quizz Pollution Internet - Energie renouvelable */
        $quizz4 = new Quizz();
        $quizz4->setTrainingSection($trainingSection4);
        $manager->persist($quizz4);
        $trainingSection4->setQuizz($quizz4);

        /* Quizz Pollution Internet - GAFA - Q1 */
        $question9 = new Question();
        $question9->setTitle('Dans GAFA, la lettre F represente quelle société ?');
        $question9->setExplanation('F comme Facebook qui a recemment changé son nom pour Meta. Alors à quand les GAMA ?');
        $manager->persist($question9);

        /* Quizz Pollution Internet - GAFA - Q1 R1 */
        $answer27 = new Answer();
        $answer27->setText('Facebook');
        $answer27->setQuestion($question9);
        $answer27->setIsAnswer(true);
        $manager->persist($answer27);
        $question9->addAnswer($answer27);

        /* Quizz Pollution Internet - GAFA - Q1 R2 */
        $answer28 = new Answer();
        $answer28->setText('Fanta');
        $answer28->setQuestion($question9);
        $manager->persist($answer28);
        $question9->addAnswer($answer28);

        /* Quizz Pollution Internet - GAFA - Q1 R3 */
        $answer29 = new Answer();
        $answer29->setText('Ferrari');
        $answer29->setQuestion($question9);
        $manager->persist($answer29);
        $question9->addAnswer($answer29);

        /* Quizz Pollution Internet - GAFA - Q1 R4 */
        $answer30 = new Answer();
        $answer30->setText('Fnac');
        $answer30->setQuestion($question9);
        $manager->persist($answer30);
        $question9->addAnswer($answer30);

        /* Quizz Pollution Internet - GAFA2 - Q2 */
        $question10 = new Question();
        $question10->setTitle('Quelle est le point commun aux sociétés qui font partie des GAFA ?');
        $question10->setExplanation('Ce sont des sociétés américaines, ayant moins de 30ans d\'existence.');
        $manager->persist($question10);

        /* Quizz Pollution Internet - GAFA2 - Q2 R1 */
        $answer31 = new Answer();
        $answer31->setText('Elles ont  des logos de même couleur');
        $answer31->setQuestion($question10);
        $manager->persist($answer31);
        $question10->addAnswer($answer31);

        /* Quizz Pollution Internet - GAFA2 - Q2 R2 */
        $answer32 = new Answer();
        $answer32->setText('Elles partagent le même marché');
        $answer32->setQuestion($question10);
        $manager->persist($answer32);
        $question10->addAnswer($answer32);

        /* Quizz Pollution Internet - GAFA2 - Q2 R3 */
        $answer33 = new Answer();
        $answer33->setText('Elles sont toutes américaines');
        $answer33->setQuestion($question10);
        $answer33->setIsAnswer(true);
        $manager->persist($answer33);
        $question10->addAnswer($answer33);

        /* Quizz Pollution Internet - GAFA2 - Q2 R4 */
        $answer34 = new Answer();
        $answer34->setText('Elles existent depuis 50 ans');
        $answer34->setQuestion($question10);
        $manager->persist($answer34);
        $question10->addAnswer($answer34);

        $quizz4->addQuestion($question9);
        $quizz4->addQuestion($question10);

        $manager->flush();
    }
}