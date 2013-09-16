<?php

namespace EtoxMicrome\EntidadBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use EtoxMicrome\EntidadBundle\Form\ProteinaType;

class EnzimaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idUniprot','text',
                  array('attr'=>
                     array(
                          'placeholder'=>'Drop here Uniprot IDs'
                            )
                        )
                    )
            ->add('proteina', 'collection' , array(
                'type' => new ProteinaType(),
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true,
            ));
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EtoxMicrome\EntidadBundle\Entity\Enzima',
            'cascade_validation' => true,
        ));
    }

    public function getName()
    {
        return 'etoxmicrome_entidadbundle_enzimatype';
    }
}
