<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UserSettingFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'username',
                TextType::class,
                [
                    'label' => 'Username',
                    'disabled' => true,
                ]
            )
            ->add(
                'password',
                PasswordType::class,
                [
                    'label' => 'Password',
                    'disabled' => true,
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => 'Email',
                    'disabled' => true,
                ]
            )
            ->add(
                'roles',
                ChoiceType::class,
                [
                    'label' => 'Roles',
                    'multiple' => true,
                    'disabled' => true,
                    'choices' => [
                        'Role 1' => 'role_1',
                        'Role 2' => 'role_2',
                    ],
                ]
            )
            ->add(
                'save',
                SubmitType::class
            )
        ;
    }
}
