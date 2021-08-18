<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, [
              'label' => 'username',
              'attr' => [
                'placeholder' => 'Username',
              ],
              'row_attr' => [
                'class' => 'form-floating',
              ],
            ])
            ->add('firstname', null, [
              'label' => 'firstname',
              'attr' => [
                'placeholder' => 'Firstname',
              ],
              'row_attr' => [
                'class' => 'form-floating',
              ],
            ])
            ->add('lastname', null, [
              'label' => 'lastname',
              'attr' => [
                'placeholder' => 'Lastname',
              ],
              'row_attr' => [
                'class' => 'form-floating',
              ],
            ])
            ->add('email', EmailType::class, [
              'label' => 'Email',
              'attr' => [
                'placeholder' => 'Email',
              ],
              'row_attr' => [
                'class' => 'form-floating',
              ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label_attr' => [
                  'class' => 'checkbox-switch',
                ],
                'label' => 'J\'accepte les CGU',
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type'  => PasswordType::class,
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
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
                'first_options' => [
                  'label' => 'Mot de Passe',
                  'row_attr' => [
                    'class' => 'form-floating',
                  ],
                 ],
                'second_options' => [
                  'label' => 'Confirmez votre mot de passe',
                  'row_attr' => [
                    'class' => 'form-floating',
                  ],
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
