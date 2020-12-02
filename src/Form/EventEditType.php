<?php

declare(strict_types=1);

namespace App\Form;

use App\DTO\EventDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventEditType extends AbstractType
{
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
                    'label' => 'Date Time:',
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
}
