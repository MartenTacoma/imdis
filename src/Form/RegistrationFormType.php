<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Country;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('name')
            ->add('affiliation')
            ->add(
                'event',
                null,
                [
                    'expanded' => true,
                    'required'=>true,
                    'label' => 'I want to register for:',
                    'help' => 'You can select multiple options'
                ]
            )
            ->add('country',
            EntityType::class,
            [
                'class' => Country::class,
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name');
                },
                'help'=>'We ask your country because we like to know where people are coming from',
                'placeholder'=>'Please select your country'
                
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'I have read the Privacy & Terms and the Code of Conduct and agree with them',
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
                        'My name, affiliation and country can be included in the public online list of participants'=>'public',
                        'My name, affiliation and country can be included in the online list of participants, but only visible for other participants'=>'login',
                        'I want to be hidden from the online list of participants'=>'hide'
                    ],
                    'expanded' => true,
                    'label' => 'Can we include you in the online list of participants?',
                    'help'=>'Your registration is always visible for the organizers'
                ]
            )
            ->add(
                'show_email',
                CheckboxType::class,
                [
                    'label' => 'Include my email address for other participants (when they are logged in)',
                    'help' => 'Only applicable if details can be shown, otherwise should be unchecked',
                    'required' => false
                ]
            )
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
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
                    'label' => 'Password',
                ],
                'second_options' => [
                    'label' => 'Repeat Password',
                ],
                'invalid_message' => 'The password fields must match.',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
            ])
            // ->add('registrationType', ChoiceType::class, [
            //     'mapped' => false,
            //     'label' => 'Are you presenter at Polar Data Forum V?',
            //         'help' => 'You are presenter if your name is bold on the program or poster list',
            //         'choices' => [
            //             'No'=>'no',
            //             'Yes, I present one or more posters' => 'poster',
            //             'Yes, I have one or more oral presentations' => 'oral',
            //             'Yes, I have one or more oral presentations and one or more posters' => 'both'
            //         ],
            //         'expanded' => true
            // ])
            // ->add(
            //     'presentations',
            //     CollectionType::class,
            //     [
            //         'entry_type' => UserPresentationType::class,
            //         'entry_options' => ['label' => false],
            //         'allow_add' => true,
            //         'allow_delete' => true,
            //         'by_reference' => false
            //     ]
            // )
            // ->add(
            //     'posters',
            //     CollectionType::class,
            //     [
            //         'entry_type' => UserPosterType::class,
            //         'entry_options' => ['label' => false],
            //         'allow_add' => true,
            //         'allow_delete' => true,
            //         'by_reference' => false
            //     ]
            // )
            // ->add('maillist', CheckboxType::class, [
            //     'label' => 'Please add me to the IMDIS mailing list to keep me updated on future editions of IMDIS',
            //     'required' => false
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
