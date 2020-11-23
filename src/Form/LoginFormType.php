<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;

class LoginFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'username',
                TextType::class,
                [
                    'label' => 'Username/Email',
                    'attr' => [
                        'data-parsley-length' => '[3, 100]',
                    ],
                    'constraints' => [
                        new Length([
                            'min' => 4,
                            'max' => 100,
                        ]),
                    ],
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
                    'label' => 'Login',
                ]
            )
        ;
    }
}
