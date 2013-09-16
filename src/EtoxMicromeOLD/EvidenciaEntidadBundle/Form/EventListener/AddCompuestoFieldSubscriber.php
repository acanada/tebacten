<?php

namespace EtoxMicrome\EvidenciaEntidadBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use EtoxMicrome\EntidadBundle\Form\CompuestoType;
use EtoxMicrome\EntidadBundle\Form\OrganismoType;
use EtoxMicrome\EntidadBundle\Form\EnzimaType;

class AddCompuestoFieldSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        // During form creation setData() is called with null as an argument
        // by the FormBuilder constructor. You're only concerned with when
        // setData is called with an actual Entity object in it (whether new
        // or fetched with Doctrine). This if statement lets you skip right
        // over the null condition.
        if (null === $data) {
            return;
        }

        // check if the Entidad associated is of type "compuesto" and in that case we add the field "compuesto" which is an entity
        $entidad=$data->getEntidad();
        $tipo=$entidad->getTipo();
        if ($tipo=="compuesto") {
            $form->add('compuesto', new CompuestoType());

        }
        if ($tipo=="organismo") {

            $form->add('organismo', new OrganismoType());
        }
        if ($tipo=="enzima") {

            $form->add('enzima', new EnzimaType());
        }
    }
}
?>