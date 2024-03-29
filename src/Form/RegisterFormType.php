<?php

namespace App\Form;

use App\Classes\DataClass\RegisterDataClass;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'username',
                TextType::class,
                [
                    'label' => 'Username',
                ]
            )
            ->add(
                'email',
                    EmailType::class,
                    [
                        'label' => 'Email',
                ]
                )
            ->add(
                'password',
                PasswordType::class,
                [
                    'label' => 'Password',
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Register',
                    'attr' => [
//                        'formnovalidate' => 'formnovalidate'
                    ],
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RegisterDataClass::class,
        ]);
    }
}
