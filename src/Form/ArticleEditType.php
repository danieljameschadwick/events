<?php

declare(strict_types=1);

namespace App\Form;

use App\DTO\EventDTO;
use App\DTO\News\ArticleDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                    'label' => 'Title:',
                    'required' => true,
                ]
            )
            ->add(
                'text',
                TextareaType::class,
                [
                    'label' => 'Body:',
                    'required' => true,
                ]
            )
            ->add(
                'author',
                UserType::class,
                [
                    'label' => 'Author:',
                    'required' => false,
                    'disabled' => true,
                ]
            )
            ->add(
                'imagePath',
                TextType::class,
                [
                    'required' => false,
                    'label' => 'Body:',
                ]
            )
            ->add(
                'strapLine',
                TextType::class,
                [
                    'required' => false,
                    'label' => 'Strap Line:',
                ]
            )
            ->add(
                'publishDate',
                DateTimeType::class,
                [
                    'required' => false,
                    'label' => 'Publish Date:',
                ]
            )
            ->add(
                'save',
                SubmitType::class
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ArticleDTO::class,
        ]);
    }
}