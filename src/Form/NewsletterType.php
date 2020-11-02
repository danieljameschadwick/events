<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class NewsletterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'email',
                EmailType::class,
                [
                    'attr' => [
                        'placeholder' => 'Your email',
                        'class' => 'w-full appearance-none bg-gray-800 rounded-sm px-4 py-3 mb-2 sm:mb-0 sm:mr-2 text-black placeholder-gray-500',
                    ],
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Subscribe',
                    'attr' => [
                        'class' => 'link--primary px-4 py-3 bg-black-darkest text-theme-primary leading-6 text-xs font-semibold rounded align-middle
                            hover:text-white hover:no-underline',
                    ],
                ]
            );
    }
}
