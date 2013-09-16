<?php

namespace EtoxMicrome\EvidenciaEntidadBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use EtoxMicrome\EvidenciaBundle\Form\EvidenciaType;
use EtoxMicrome\EntidadBundle\Form\EntidadType;
use EtoxMicrome\EvidenciaEntidadBundle\Form\EventListener\AddCompuestoFieldSubscriber;

class EvidenciaEntidadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('textminingName', 'text',
                  array('attr'=>
                     array(
                          'placeholder'=>'Type Name of Entity'
                            )
                        )
                    )
            //->add('entidad', new EntidadType())
            /*->add('evidencia', 'hidden', array(
                'data_class' => 'EtoxMicrome\EvidenciaBundle\Entity\Evidencia'
                ))
            */

        ;
        $builder->addEventSubscriber(new AddCompuestoFieldSubscriber());
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EtoxMicrome\EvidenciaEntidadBundle\Entity\EvidenciaEntidad',
            'cascade_validation' => true,
        ));
    }

    public function getName()
    {
        return 'etoxmicrome_evidenciaentidadbundle_evidenciaentidadtype';
    }
}
