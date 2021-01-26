<?php

namespace App\Form;

use App\Entity\PosterSession;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PosterSessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, ['widget'=> 'single_text'])
            ->add('time_start', TimeType::class, ['widget'=> 'single_text'])
            ->add('time_end', TimeType::class, ['widget'=> 'single_text'])
            ->add('theme')
            // ->add('presentation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PosterSession::class,
        ]);
    }
}
