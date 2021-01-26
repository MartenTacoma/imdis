<?php

namespace App\Form;

use App\Entity\ProgramSession;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProgramSessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('block')
            ->add('time_start', TimeType::class, ['widget'=> 'single_text'])
            ->add('title')
            ->add('theme')
            ->add(
                'chair',
                CollectionType::class,
                [
                    'entry_type' => SessionChairType::class,
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
            'data_class' => ProgramSession::class,
        ]);
    }
}
