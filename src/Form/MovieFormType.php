<?php

namespace App\Form;

use App\Entity\Movie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class MovieFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'bg-transparent block border-b-2 w-full h-20 text-6xl outline-none',
                    'placeholder' => 'Enter Title...',
                ],
                'label' => false,
                'required' => false,
            ])
            ->add('releaseYear', IntegerType::class, [
                'attr' => [
                    'class' => 'bg-transparent block mt-10 border-b-2 w-full h-20 text-6xl outline-none',
                    'placeholder' => 'Enter Release Year...',
                ],
                'label' => false,
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'bg-transparent block mt-10 border-b-2 w-full h-20 text-6xl outline-none',
                    'placeholder' => 'Enter Description...',
                ],
                'label' => false,
                'required' => false,
            ])
            ->add('imagePath', FileType::class, [
                'attr' => [
                    'class' => 'py-10',
                ],
                'label' => false,
                'required' => false,
                'mapped' => is_null($builder->getData()->getId()),
            ])
            // ->add('actors')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}