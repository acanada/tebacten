<?php

namespace EtoxMicrome\EntidadBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProteinaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idOrganismNCBI', 'text')
            ->add('idUniprot', 'text')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EtoxMicrome\EntidadBundle\Entity\Proteina',
            'cascade_validation' => true,
        ));
    }

    public function getName()
    {
        return 'etoxmicrome_entidadbundle_proteinatype';
    }
}
