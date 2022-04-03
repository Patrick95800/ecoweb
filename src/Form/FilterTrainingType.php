<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class FilterTrainingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status', ChoiceType::class, [
                'label' => 'Par status',
                'mapped' => false,
                'choices' => [
                    'Formations en cours' => 'pending',
                    'Formations terminées' => 'done',
                ]
            ])
        ;
    }
}
