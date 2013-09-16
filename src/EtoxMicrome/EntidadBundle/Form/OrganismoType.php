<?php

namespace EtoxMicrome\EntidadBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrganismoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idNCBI','text',
                  array('attr'=>
                     array(
                          'placeholder'=>'Drop here the idNCBI'
                            )
                        )
                    )
            //->add('dueDate', null, array('mapped' => false));
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EtoxMicrome\EntidadBundle\Entity\Organismo',
            'cascade_validation' => true,
        ));
    }

    public function getName()
    {
        return 'etoxmicrome_entidadbundle_organismotype';
    }
}
