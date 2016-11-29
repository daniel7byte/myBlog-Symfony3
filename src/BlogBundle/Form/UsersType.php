<?php

namespace BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ["label" => "Nombre", "required" => "required", "attr" => ["class" => "form-control"]])
            ->add('surname', TextType::class, ["label" => "Apellido", "required" => "required", "attr" => ["class" => "form-control"]])
            ->add('email', EmailType::class, ["label" => "Correo", "required" => "required", "attr" => ["class" => "form-control"]])
            ->add('password', PasswordType::class, ["label" => "Contraseña", "required" => "required", "attr" => ["class" => "form-control"]])
            ->add('Guardar', SubmitType::class, ["attr" => ["class" => "btn btn-success"]])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BlogBundle\Entity\Users'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'blogbundle_users';
    }


}
