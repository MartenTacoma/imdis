<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UserType extends AbstractType
{
    private $auth;
    public function __construct(AuthorizationCheckerInterface $auth)
    {
        $this->auth = $auth;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('name')
            ->add('affiliation')
            ->add('country', CountryType::class, ['required'=>false]);
        if ($this->auth->isGranted('ROLE_ADMIN')){
            $builder->add(
                'roles',
                ChoiceType::class,
                [
                    'choices' => ['Super admin' => 'ROLE_SUPER_ADMIN', 'Admin' => 'ROLE_ADMIN', 'Manager' => 'ROLE_MANAGER'],
                    'multiple' => true,
                    'expanded' => true
                ]
            );
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
