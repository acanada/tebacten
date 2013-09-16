<?php

namespace EtoxMicrome\EntidadBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EntidadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre','text', array())
            /*->add('tipo', 'choice', array(
                    'choices' =>array ('organismo' => 'organismo','compuesto' => 'compuesto','enzima' => 'enzima')
                ))
            */
            ->add('tipo','text', array())
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EtoxMicrome\EntidadBundle\Entity\Entidad',
            'cascade_validation' => true,
        ));
    }

    public function getName()
    {
        return 'etoxmicrome_entidadbundle_entidadtype';
    }
}
