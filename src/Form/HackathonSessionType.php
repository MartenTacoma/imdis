<?php

namespace App\Form;

use App\Entity\HackathonSession;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class HackathonSessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, ['widget'=> 'single_text'])
            ->add('timeStart', TimeType::class, ['widget'=> 'single_text'])
            ->add('timeEnd', TimeType::class, ['widget'=> 'single_text'])
            ->add('meetingUrl')
            ->add('meetingId')
            ->add('meetingPasscode')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => HackathonSession::class,
        ]);
    }
}