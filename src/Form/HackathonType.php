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
            ->add('intro', null, ['label' => 'Introduction text', 'help'=>'Shown on list and as first paragraph on hackathon page'])
            ->add('description', null, ['label' => 'Description', 'help'=>'Shown after intro on hackathon page'])
            ->add('slug', null, ['label'=>'Url slug (the part after hackathon/)'])
            ->add(
                'contact',
                CollectionType::class,
                [
                    'entry_type' => HackathonContactType::class,
                    'entry_options' => ['label' => true],
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false
                ]
            )
            ->add(
                'links',
                CollectionType::class,
                [
                    'entry_type' => HackathonLinkType::class,
                    'entry_options' => ['label' => true],
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
