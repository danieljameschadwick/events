<?php

declare(strict_types=1);

namespace App\Form;

use App\DTO\NewsletterDTO;
use App\Entity\User\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class NewsletterType extends AbstractType
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

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
                        'class' => 'w-full appearance-none bg-white rounded-sm px-4 py-3 mb-2 sm:mb-0 sm:mr-2 text-black-base placeholder-gray-500',
                    ],
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Subscribe',
                    'attr' => [
                        'class' => 'link--primary px-4 py-3 bg-black-darkest text-theme-primary leading-6 text-xs font-semibold rounded align-middle hover:text-white hover:no-underline dark:text-white',
                    ],
                ]
            )
            ->addEventListener(FormEvents::POST_SUBMIT, [$this, 'setUser']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NewsletterDTO::class,
        ]);
    }

    /**
     * @param FormEvent $formEvent
     */
    public function setUser(FormEvent $formEvent): void
    {
        $newsletterDTO = $formEvent->getData();
        $form = $formEvent->getForm();

        $user = $this->security->getUser();

        if (!$user instanceof User) {
            return;
        }

        $newsletterDTO->setUser($user);
    }
}
