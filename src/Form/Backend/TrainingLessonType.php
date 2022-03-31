<?php

namespace App\Form\Backend;

use App\Entity\TrainingLesson;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class TrainingLessonType extends AbstractType
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
            ->add('video', TextareaType::class,[
                'label' => 'Vidéo',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir la description'])
                ]
            ])
            ->add('explanation', TextareaType::class, [
                'label' => 'Description',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir la description'])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TrainingLesson::class,
        ]);
    }
}
