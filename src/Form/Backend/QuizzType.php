<?php

namespace App\Form\Backend;

use App\Entity\Hotel;
use App\Entity\Quizz;
use App\Entity\TrainingSection;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class QuizzType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('trainingSection', EntityType::class, [
                'label' => 'Section associée',
                'class' => TrainingSection::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('ts')
                        ->orderBy('ts.title', 'ASC');
                },
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez sélectionner la section associée'])
                ]
            ])
            ->add('questions', CollectionType::class, [
                'label' => 'Questions'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quizz::class,
        ]);
    }
}
