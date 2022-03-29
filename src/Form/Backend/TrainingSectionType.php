<?php

namespace App\Form\Backend;

use App\Entity\TrainingSection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class TrainingSectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir le titre'])
                ]
            ])
            ->add('slug', TextType::class, [
                'label' => 'URL raccourcie',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir l\'URL raccourcie'])
                ]
            ])
            ->add('lessons', CollectionType::class, [
                'label' => 'Leçons',
                'entry_type' => TrainingLessonType::class,
                'allow_add' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TrainingSection::class,
        ]);
    }
}
