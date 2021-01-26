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

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('name')
            ->add('affiliation')
            ->add('country', CountryType::class, ['required'=>false, 'help'=>'We ask your country for statistics to report to the EU'])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'I have read the terms above and agree with them',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add(
                'show_in_list',
                ChoiceType::class,
                [
                    'choices' => [
                        'My personal details can be included in the public online list of participants'=>'public',
                        'My personal details can be included in the online list of participants, but only visible for other participants'=>'login',
                        'I want to be hidden from the online list of participants'=>'hide'
                    ],
                    'expanded' => true
                ]
            )
            ->add(
                'show_email',
                CheckboxType::class,
                [
                    'label' => 'Show my email for logged in users',
                    'help' => 'Only applicable if details can be shown'
                ]
            )
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
