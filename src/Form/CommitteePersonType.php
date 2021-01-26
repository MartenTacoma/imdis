<?php

namespace App\Form;

use App\Entity\CommitteePerson;
use App\Entity\Person;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class CommitteePersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'person',
                EntityType::class,
                [
                    'class' => Person::class,
                    'query_builder' => function(EntityRepository $er){
                        return $er->createQueryBuilder('p')
                            ->orderBy('p.name');
                    }
                ]
            )
            ->add('sort')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CommitteePerson::class,
        ]);
    }
}
