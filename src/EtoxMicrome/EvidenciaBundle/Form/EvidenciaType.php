<?php

namespace EtoxMicrome\EvidenciaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use EtoxMicrome\OrigenBundle\Form\OrigenType;
use EtoxMicrome\EvidenciaEntidadBundle\Form\EvidenciaEntidadType;
class EvidenciaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('code')
            //->add('texto')
            //->add('curated')
            //->add('origen', new OrigenType())
            ->add('evidenciaEntidad', 'collection' , array(
                'type' => new EvidenciaEntidadType(),
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true,
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EtoxMicrome\EvidenciaBundle\Entity\Evidencia',
            'cascade_validation' => true,
        ));
    }

    public function getName()
    {
        return 'etoxmicrome_evidenciabundle_evidenciatype';
    }
}
