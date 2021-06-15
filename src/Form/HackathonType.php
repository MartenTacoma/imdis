<?php

namespace App\Form;

use App\Entity\Hackathon;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class HackathonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'event',
                null,
                [
                    'expanded' => true,
                    'required'=>true
                ]
            )
            ->add('title')
            ->add('description')
            ->add(
                'contact',
                CollectionType::class,
                [
                    'entry_type' => HackathonContactType::class,
                    'entry_options' => ['label' => false],
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false
                ]
            )
            ->add(
                'session',
                CollectionType::class,
                [
                    'entry_type' => HackathonSessionType::class,
                    'entry_options' => ['label' => false],
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Hackathon::class,
        ]);
    }
}
