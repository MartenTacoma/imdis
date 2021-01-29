<?php

namespace App\Form;

use App\Entity\Poster;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PosterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('video_url')
            ->add('comment_url')
            ->add('preview_url')
            ->add('download_url')
            ->add('session_url')
            ->add('abstract')
            ->add('poster_session')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Poster::class,
        ]);
    }
}
