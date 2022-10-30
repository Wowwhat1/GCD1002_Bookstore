<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\OrderDetail;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Quantity')
            ->add('OrderId')
            ->add('Book',
                EntityType::class, [
                    'class' => Book::class,
                    'choice_label' => 'Title',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OrderDetail::class,
        ]);
    }
}
