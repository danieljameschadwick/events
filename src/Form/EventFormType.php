<?php

declare(strict_types=1);

namespace App\Form;

use App\DTO\AddressDTO;
use App\DTO\EventDTO;
use App\Entity\Event;
use App\Entity\Location\Address;
use App\Entity\User\User;
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

class EventFormType extends AbstractType
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
                'name',
                TextType::class,
                [
                    'required' => true,
                    'label' => 'Event Name:',
                ]
            )
            ->add(
                'startDateTime',
                DateTimeType::class,
                [
                    'required' => true,
                    'label' => 'Start Date Time:',
                ]
            )
            ->add(
                'endDateTime',
                DateTimeType::class,
                [
                    'required' => false,
                    'label' => 'End Date Time:',
                ]
            )
            ->add(
                'address',
                AddressType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'organiser',
                UserType::class,
                [
                    'required' => false,
                    'disabled' => true,
                ]
            )
            ->add(
                'submit',
                SubmitType::class
            )
            ->addEventListener(
                FormEvents::POST_SUBMIT,
                [$this, 'setUser']
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EventDTO::class,
        ]);
    }

    /**
     * @param FormEvent $formEvent
     */
    public function setUser(FormEvent $formEvent): void
    {
        $user = $this->security->getUser();

        if (!$user instanceof User) {
            $this->session
                ->getFlashBag()
                ->add('error', 'User not found.');

            throw new \InvalidArgumentException('User not found.');
        }

        /** @var EventDTO $event */
        $eventDTO = $formEvent->getData();
        $eventDTO->setOrganiser($user);

        /** @var EventDTO $addressDTO */
        $addressDTO = $eventDTO->getAddress();

        if ($addressDTO instanceof AddressDTO) {
            $eventDTO->setAddress(
                $addressDTO->setUser($user)
            );
        }
    }
}
