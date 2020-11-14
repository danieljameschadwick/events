<?php

declare(strict_types=1);

namespace App\Form;

use App\DTO\SignUpDTO;
use App\Entity\Event;
use App\Entity\User\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class SignUpFormType extends AbstractType
{
    /**
     * @var Security
     */
    private $security;

    /**
     * @var Session
     */
    private $session;

    /**
     * EventFormType constructor.
     *
     * @param Security $security
     * @param Session  $session
     */
    public function __construct(Security $security, Session $session)
    {
        $this->security = $security;
        $this->session = $session;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'firstName',
                TextType::class,
                [
                    'required' => true,
                    'label' => 'First Name:',
                ]
            )
            ->add(
                'lastName',
                TextType::class,
                [
                    'required' => true,
                    'label' => 'Last Name:',
                ]
            )
            ->add(
                'signUpDate',
                DateTimeType::class,
                [
                    'required' => true,
                ]
            )
            ->add(
                'user',
                UserType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'event',
                EntityType::class,
                [
                    'required' => true,
                    'class' => Event::class,
                ]
            )
            ->add(
                'submit',
                SubmitType::class
            )
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                [$this, 'setUser']
            )
        ;
    }

    /**
     * @param FormEvent $formEvent
     */
    public function setUser(FormEvent $formEvent): void
    {
        $user = $this->security->getUser();

        if (!$user instanceof User) {
            return;
        }

        /** @var SignUpDTO $signUpDTO */
        $signUpDTO = $formEvent->getData();
        $signUpDTO->setUser($user);

        $formEvent->setData($signUpDTO);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SignUpDTO::class,
        ]);
    }
}
