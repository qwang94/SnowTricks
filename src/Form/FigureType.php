<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Figure;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FigureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la figure',
                'row_attr' => [
                    'class' => 'form-group figure-field col-md-6',
                  ],
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'row_attr' => [
                    'class' => 'form-group figure-field',
                  ],
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('slug', TextType::class, [
                'label' => 'Slug',
                'row_attr' => [
                    'class' => 'form-group figure-field col-md-6',
                  ],
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'row_attr' => [
                    'class' => 'form-group figure-field',
                  ],
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('media', FileType::class, [
                'label' => 'Ajout des images',
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                'row_attr' => [
                    'class' => 'form-group figure-field col-md-6',
                  ],
                'attr' => [
                    'class' => 'form-control-file',
                ]
            ])
            ->add('videos', TextType::class, [
                'label' => 'Lien youtube',
                'mapped' => false,
                'required' => false,
                'row_attr' => [
                    'class' => 'form-group figure-field col-md-6',
                  ],
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Figure::class,
        ]);
    }
}
