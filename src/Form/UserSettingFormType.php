<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\User\Role;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
                EntityType::class,
                [
                    'label' => 'Roles',
                    'multiple' => true,
                    'disabled' => true,
                    'class' => Role::class,
                ]
            )
            ->add(
                'save',
                SubmitType::class
            )
        ;
    }
}
