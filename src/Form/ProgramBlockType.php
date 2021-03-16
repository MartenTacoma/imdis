<?php

namespace App\Form;

use App\Entity\ProgramBlock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProgramBlockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, ['widget' => 'single_text'])
            ->add('time_start', TimeType::class, ['widget'=> 'single_text'])
            ->add('time_end', TimeType::class, ['widget'=> 'single_text'])
            ->add('session_url', TextType::class, [
                'required' => false,
                'label' => 'Meeting url',
            ])
            ->add('zoom_id', TextType::class, [
                'required' => false,
                'label' => 'Meeting id'
            ])
            ->add('zoom_pass', TextType::class, [
                'required' => false,
                'label' => 'Password'
            ])
            ->add('zoom_pass_phone', TextType::class, [
                'required' => false,
                'label' => 'Numeric password'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProgramBlock::class,
        ]);
    }
}
