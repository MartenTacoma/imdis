<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('name')
            ->add('affiliation')
            ->add('country', CountryType::class, ['required'=>false, 'help'=>'We ask your country for statistics to report to the EU'])
            ->add(
                'show_in_list',
                ChoiceType::class,
                [
                    'choices' => [
                        'My personal details can be included in the public online list of participants'=>'public',
                        'My personal details can be included in the online list of participants, but only visible for other participants'=>'login',
                        'I want to be hidden from the online list of participants'=>'hide'
                    ],
                    'expanded' => true,
                    'label' => 'Can we include you in the online list of participants?'
                ]
            )
            ->add(
                'show_email',
                ChoiceType::class,
                [
                    'label' => 'Do you also want your email address displayed for other participants (when they are logged in)?',
                    'help' => 'Only applicable if details can be shown, otherwise should be no',
                    'choices' => [
                        'Yes'=>'1',
                        'No' => '0'
                    ],
                    'expanded' => true
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
