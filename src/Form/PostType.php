<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, [
                'attr' => [
                    'class' => 'input is-primary'
                ],
                'row_attr' => [
                    'class' => 'field'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('image', FileType::class, [
                'mapped' => false,
                'row_attr' => [
                    'class' => 'field'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'label' => false,
                'row_attr' => [
                    'class' => 'field select is-rounded is-primary'
                ],

            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'button is-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
