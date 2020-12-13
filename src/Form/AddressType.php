<?php

declare(strict_types=1);

namespace App\Form;

use App\DTO\AddressDTO;
use App\Entity\Location\Country;
use App\Entity\Location\Region;
use App\Interfaces\DoctrineAwareInterface;
use App\Traits\EntityManagerTrait;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AddressType extends AbstractType implements DoctrineAwareInterface
{
    use EntityManagerTrait;

    private const NAME = 'name';
    private const ADDRESS_LINE_1 = 'addressLine1';
    private const ADDRESS_LINE_2 = 'addressLine2';
    private const ADDRESS_LINE_3 = 'addressLine3';
    private const ADDRESS_LINE_4 = 'addressLine4';
    private const POST_CODE = 'postCode';
    private const LATITUDE = 'latitude';
    private const LONGITUDE = 'longitude';
    private const COUNTRY = 'country';
    private const REGION = 'region';
    private const USER = 'user';

    private const ENABLED_FIELDS = [
        self::NAME,
        self::ADDRESS_LINE_1,
        self::POST_CODE,
        self::COUNTRY,
        self::REGION,
        self::USER,
    ];

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'enabled',
                CheckboxType::class,
                [
                    'mapped' => false,
                    'label' => 'Enable Address:',
                ]
            )
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Address Name:',
                    'constraints' => [
                        new NotBlank()
                    ],
                ]
            )
            ->add(
                'addressLine1',
                TextType::class,
                [
                    'label' => 'Address Line 1:',
                    'constraints' => [
                        new NotBlank()
                    ],
                ]
            )
            ->add(
                'addressLine2',
                TextType::class,
                [
                    'required' => false,
                    'label' => 'Address Line 2:',
                ]
            )
            ->add(
                'addressLine3',
                TextType::class,
                [
                    'required' => false,
                    'label' => 'Address Line 3:',
                ]
            )
            ->add(
                'addressLine4',
                TextType::class,
                [
                    'required' => false,
                    'label' => 'Address Line 4:',
                ]
            )
            ->add(
                'postCode',
                TextType::class,
                [
                    'label' => 'Post Code:',
                    'constraints' => [
                        new NotBlank()
                    ],
                ]
            )
            ->add(
                'latitude',
                TextType::class,
                [
                    'required' => false,
                    'label' => 'Latitude:',
                ]
            )
            ->add(
                'longitude',
                TextType::class,
                [
                    'required' => false,
                    'label' => 'Longitude:',
                ]
            )
            ->add(
                'country',
                EntityType::class,
                [
                    'label' => 'Country:',
                    'class' => Country::class,
                    'choice_label' => function (?Country $country) {
                        return $country instanceof Country
                            ? $country->getName()
                            : null;
                    },
                    'choices' =>
                        $this->getManager()
                            ->getRepository(Country::class)
                            ->getAll(),
                    'constraints' => [
                        new NotBlank()
                    ],
                ]
            )
            ->add(
                'region',
                EntityType::class,
                [
                    'label' => 'Region:',
                    'class' => Region::class,
                    'choice_label' => function (?Region $region) {
                        return $region instanceof Region
                            ? $region->getName()
                            : null;
                    },
                    'choices' =>
                        $this->getManager()
                            ->getRepository(Region::class)
                            ->getAll(),
                    'constraints' => [
                        new NotBlank()
                    ],
                ]
            )
            ->add(
                'user',
                UserType::class,
                [
                    'constraints' => [
                        new NotBlank()
                    ],
                ]
            )
            ->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'isRequired']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AddressDTO::class,
        ]);
    }

    /**
     * @param FormEvent $formEvent
     */
    public function isRequired(FormEvent $formEvent): void
    {
        $data = $formEvent->getData();
        $form = $formEvent->getForm();
        $addressEnabled = $data['enabled'] ?? false;

        if ($addressEnabled) {
            $this->requireAddress($form);
        }

        if (!$addressEnabled) {
            $this->requireAddress($form, false);
        }
    }

    /**
     * @param FormInterface $form
     * @param bool $required
     */
    private function requireAddress(FormInterface $form, bool $required = true): void
    {
        foreach (self::ENABLED_FIELDS as $fieldKey) {
            $field = $form->get($fieldKey);
            $config = $field->getConfig();

            $type = $config->getType()->getInnerType();

            $options = $config->getOptions();
            $options['required'] = $required;

            if (!$required) {
                $options['constraints'] = [];
            }

            $form->remove($fieldKey)
                ->add(
                    $fieldKey,
                    get_class($type),
                    $options
                );
        }
    }
}