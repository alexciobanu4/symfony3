<?php

namespace AlexBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UsuariosType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                "required"=>"required",
                "attr"=>array("class"=>"form-control")))
            ->add('surname', TextType::class, array(
                "required"=>"required",
                "attr"=>array("class"=>"form-control")))
            ->add('description', TextareaType::class, array(
                "required"=>"required",
                "attr"=>array("class"=>"form-control")))
            ->add('email', TextType::class, array(
                "required"=>"required",
                "attr"=>array("class"=>"form-control")))
            ->add('password', ChoiceType::class, array(
                "choices" => array(
                    "hombre" => "Hombre",
                    "mujer" => "Mujer"
                ),
                "attr"=>array("class"=>"form-control")
            ))
            // ->add('precio', CheckboxType::class, array(
            //     "label" => "Mostrar precio",
            //     "required" => true
            // ))
            ->add('save', SubmitType::class, array('label' => 'Guardar', 'attr' => array('class' => 'btn btn-primary')));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AlexBundle\Entity\Usuarios'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'alexbundle_usuarios';
    }


}
