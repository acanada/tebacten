<?php

namespace EtoxMicrome\EntidadBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CompuestoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('chebiId','text',
                  array('attr'=>
                     array(
                          'placeholder'=>'ChebiId'
                            )
                        )
                    )
            ->add('inputOutput', 'choice', array(
                    'choices' =>array ('select' => '','input' => 'input','output' => 'output')
                ))
            //->add('dueDate', null, array('mapped' => false));
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EtoxMicrome\EntidadBundle\Entity\Compuesto',
            'cascade_validation' => true,
        ));
    }

    public function getName()
    {
        return 'etoxmicrome_entidadbundle_compuestotype';
    }
}
