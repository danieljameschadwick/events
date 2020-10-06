<?php

declare(strict_types=1);

namespace App\Form;

use App\DTO\EventDTO;
use App\DTO\UserDTO;
use App\Entity\User;
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
     * @param Session $session
     */
    public function __construct(Security $security, Session $session)
    {
        $this->security = $security;
        $this->session = $session;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'required' => true,
                    'label' => 'Event Name:'
                ]
            )
            ->add(
                'dateTime',
                DateTimeType::class,
                [
                    'required' => true,
                    'label' => 'Date Time:'
                ]
            )
            ->add(
                'organiser',
                UserType::class,
                [
                    'required' => true,
                ]
            )
            ->add(
                'submit',
                SubmitType::class
            )
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                [$this, 'setUser']
            );
    }

    public function setUser(FormEvent $formEvent): void
    {
        $user = $this->security->getUser();

        if (!$user instanceof User) {
            $this->session
                ->getFlashBag()
                ->add('error', 'User not found.');

            throw new \InvalidArgumentException('User not found.');
        }

        $eventDTO = EventDTO::create();
        $eventDTO->setOrganiser($user);

dump($eventDTO);

        $formEvent->setData($eventDTO);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EventDTO::class
        ]);
    }
}