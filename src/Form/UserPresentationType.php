<?php

namespace App\Form;

use App\Entity\UserPresentation;
use App\Entity\Presentation;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserPresentationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'presentation',
                EntityType::class,
                [
                    'class' => Presentation::class,
                    'group_by' => 'program_session',
                    'query_builder' => function(EntityRepository $er){
                        return $er->createQueryBuilder('p')
                            ->join('p.program_session', 's')
                            ->join('s.block', 'b')
                            ->join('p.type', 't')
                            ->orderBy('b.date, b.time_start, p.time_start')
                            ->where('t.consent = 1');
                    }
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserPresentation::class,
        ]);
    }
}
