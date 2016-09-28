<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Rollerworks\Bundle\PasswordStrengthBundle\Validator\Constraints\PasswordRequirements;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'First name',
                'required' => true,
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Last name',
                'required' => true,
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Password',
                ],
                'second_options' => [
                    'label' => 'Confirm password',
                ],
                'invalid_message' => 'The passwords does not match',
                
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email address',
                'required' => true,
            ])
            ->add('address1', TextType::class, [
                'label' => 'Address 1',
                'required' => true,
            ])
            ->add('address2', TextType::class, [
                'label' => 'Address 2',
                'required' => true,
            ])
            ->add('city', TextType::class, [
                'label' => 'City',
                'required' => true,
            ])
            ->add('postCode', TextType::class, [
                'label' => 'Post Code',
                'required' => true,
            ])
            ->add('country', CountryType::class, [
                'label' => 'Country',
                'required' => true,
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'    	=> User::class,
        ]);
    }

    public function getName()
    {
        return 'app_bundle_registration_type';
    }
}
