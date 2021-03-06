<?php

namespace App\Form\Backend;

use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Intitulé',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir l\'intitulé de la question'])
                ]
            ])
            ->add('explanation', TextareaType::class, [
                'label' => 'Explication',
                'required' => false
            ])
            ->add('answers', CollectionType::class, [
                'label' => 'Réponses',
                'entry_type' => AnswerType::class,
                'allow_add' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
