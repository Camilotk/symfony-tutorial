<?php

namespace App\Form;

use App\Entity\Post;
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
                    'class' => 'input'
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
