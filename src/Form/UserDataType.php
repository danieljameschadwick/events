<?php

declare(strict_types=1);

namespace App\Form;

use App\DTO\UserDTO;
use App\Entity\User;
use App\Form\Type\UuidType;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserDataType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'uuid',
                TextType::class
            )
            ->add(
                'username',
                TextType::class
            )
            ->add(
                'email',
                EmailType::class
            )
        ;

        $builder->get('uuid')
            ->addModelTransformer(new CallbackTransformer(
                function ($uuid) {
                    return $uuid;
                },
                function ($uuidString) {
                    return Uuid::fromString($uuidString);
                }
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserDTO::class
        ]);
    }
}