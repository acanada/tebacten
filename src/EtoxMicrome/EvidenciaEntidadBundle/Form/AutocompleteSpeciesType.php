<?php

namespace EtoxMicrome\EvidenciaEntidadBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use EtoxMicrome\EvidenciaBundle\Form\EvidenciaType;
use EtoxMicrome\EntidadBundle\Form\EntidadType;

class AutocompleteSpeciesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('soccer_player', 'genemu_jqueryautocomplete_entity', array(
            'class' => 'EtoxMicrome\EntidadBundle\Entity\Entidad',
            'property' => 'nombre',
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
       /* $resolver->setDefaults(array(
            'data_class' => 'EtoxMicrome\EntidadBundle\Entity\Entidad',
        ));
        */
    }

    public function getName()
    {
        return 'etoxmicrome_evidenciaentidadbundle_autocompletespeciestype';
    }
}
