<?php

namespace EtoxMicrome\OrigenBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrigenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipo')
            ->add('texto')
            ->add('url')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EtoxMicrome\OrigenBundle\Entity\Origen'
        ));
    }

    public function getName()
    {
        return 'etoxmicrome_origenbundle_origentype';
    }
}
