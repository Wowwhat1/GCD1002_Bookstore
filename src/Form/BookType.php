<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Category;
use App\Entity\Publisher;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Title')
            ->add('Author')
            ->add('Cost')
            ->add('Image', FileType::class, [
                'label' => 'Image',

                'mapped' => false,

                'required' => false,
            ])
            ->add(
                'Category',
                EntityType::class,
                [
                    'class' => Category::class,
                    'choice_label' => 'Name',
                ]
            )
            ->add(
                'Publisher',
                EntityType::class,
                [
                    'class' => Publisher::class,
                    'choice_label' => 'Name',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
