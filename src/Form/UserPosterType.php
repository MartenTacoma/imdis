<?php

namespace App\Form;

use App\Entity\UserPoster;
use App\Entity\Poster;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserPosterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'poster',
                EntityType::class,
                [
                    'class' => Poster::class,
                    'group_by' => 'poster_session',
                    'query_builder' => function(EntityRepository $er){
                        return $er->createQueryBuilder('p')
                            ->join('p.poster_session', 's')
                            ->join('p.abstract', 'a')
                            ->orderBy('s.date, s.time_start, a.imdisId');
                    },
                    'placeholder' => 'Please select your poster'
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserPoster::class,
        ]);
    }
}
