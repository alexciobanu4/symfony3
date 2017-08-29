<?php

namespace BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, array("label"=>"Nombre","required"=>false, "attr" =>array(
				"class" => "form-name form-control",
			)))
            ->add('surname',TextType::class, array("label"=>"Apellido","required"=>false, "attr" =>array(
				"class" => "form-surname form-control",
			)))
            ->add('email',EmailType::class, array(
                "label"=>"Email", 
                'required' => true, 
                "attr" =>array(
    				"class" => "form-email form-control",
    			)))
            ->add('password',RepeatedType::class, array(
                'type' => PasswordType::class,
                'required' => true,
                'invalid_message' => 'Las contraseñas deben coincidir',
                'first_options'  => array('label' => 'Contraseña'),
                'second_options' => array('label' => 'Confirmar contraseña'),
                "attr" =>array(
    				"class" => "form-password form-control",
    			)))
            ->add('role', ChoiceType::class,array(
                "label" => "Rol:",
                "choices"=> array(
                    "Admin" => "ROLE_ADMIN",
                    "User" => "ROLE_USER"
                ),
                "attr" =>array("class" => "form-control")
            ))
			->add('Guardar', SubmitType::class, array("attr" =>array(
				"class" => "form-submit btn btn-success",
			)))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BlogBundle\Entity\User'
        ));
    }
}
