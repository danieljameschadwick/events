<?php

declare(strict_types=1);

namespace App\Form;

use Ramsey\Uuid\Uuid;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
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
                    if (null === $uuidString) {
                        return null;
                    }

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
            'data_class' => null, // todo: think of eloquent approach to the User problem
            'mapped' => false,
        ]);
    }
}
