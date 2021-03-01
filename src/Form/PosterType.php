<?php

namespace App\Form;

use App\Entity\Poster;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PosterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('abstract')
            ->add('poster_session')
            ->add('video_url', null, ['help'=>'Link to the poster pitch on YouTube'])
            ->add('comment_url', null, ['help'=>'Link to the poster on google Drive'])
            ->add('download_url', null, ['help' => 'Link to the poster at the main IMDIS website at IFREMER'])
            ->add('previewFile', VichImageType::class, [
                'required' => false,
                'help' => '300 pixels wide and 200 pixels high'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Poster::class,
        ]);
    }
}
