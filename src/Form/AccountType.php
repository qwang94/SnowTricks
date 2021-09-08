<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, [
              'label' => 'Username',
              'row_attr' => [
                'class' => 'form-floating',
              ],
            ])
            ->add('firstname', null, [
              'label' => 'Firstname',
              'row_attr' => [
                'class' => 'form-floating',
              ],
            ])
            ->add('lastname', null, [
              'label' => 'Lastname',
              'row_attr' => [
                'class' => 'form-floating',
              ],
            ])
            ->add('email', EmailType::class, [
              'label' => 'Email',
              'row_attr' => [
                'class' => 'form-floating',
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
