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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType implements DoctrineAwareInterface
{
    use EntityManagerTrait;
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'required' => true,
                    'label' => 'Address Name:',
                ]
            )
            ->add(
                'addressLine1',
                TextType::class,
                [
                    'required' => true,
                ]
            )
            ->add(
                'addressLine2',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'addressLine3',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'addressLine4',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'postCode',
                TextType::class,
                [
                    'required' => true,
                ]
            )
            ->add(
                'latitude',
                TextType::class,
                [
                    'required' => false,
                ]
            )

            ->add(
                'longitude',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'country',
                EntityType::class,
                [
                    'required' => true,
                    'class' => Country::class,
                    'choice_label' => function (?Country $country) {
                        return $country instanceof Country
                            ? $country->getName()
                            : null;
                    },
                    'choices' =>
                        $this->getManager()
                            ->getRepository(Country::class)
                            ->getAll()
                ]
            )
            ->add(
                'region',
                EntityType::class,
                [
                    'required' => true,
                    'class' => Region::class,
                    'choice_label' => function (?Region $region) {
                        return $region instanceof Region
                            ? $region->getName()
                            : null;
                    },
                    'choices' =>
                        $this->getManager()
                            ->getRepository(Region::class)
                            ->getAll()
                ]
            )
            ->add(
                'user',
                UserType::class,
                [
                    'required' => true,
                ]
            )
        ;
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
}