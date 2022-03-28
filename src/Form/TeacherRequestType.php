<?php

namespace App\Form;

use App\Entity\TeacherRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class TeacherRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom',
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom',
            ])
            ->add('email', TextType::class, [
                'label' => 'Votre adresse email',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir l\'adresse email'])
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Votre mot de passe',
                'mapped' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir le mot de passe'])
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Votre description',
            ])
            ->add('photo', FileType::class,[
                'label' => 'Votre photo',
                'multiple' => false,
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TeacherRequest::class,
        ]);
    }
}
