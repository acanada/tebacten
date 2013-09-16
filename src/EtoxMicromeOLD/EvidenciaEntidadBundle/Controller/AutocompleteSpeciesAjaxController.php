<?php

namespace EtoxMicrome\EvidenciaEntidadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use EtoxMicrome\EvidenciaEntidadBundle\Form\AutocompleteSpeciesType;

class AutocompleteSpeciesAjaxController extends Controller
{
    /**
     * @Route("/ajax_species", name="ajax_species")
     */
    public function ajaxEntidadAction(Request $request)
    {
        $alert="llega aqui";
        ldd($alert);
        $value = $request->get('term');

        $em = $this->getDoctrine()->getEntityManager();
        $entidades = $em->getRepository('EntidadBundle:Entidad')->findAjaxValue($value);

        $json = array();
        foreach ($entidades as $entidad) {
            $json[] = array(
                'label' => $entidad->getNombre(),
                'value' => $member->getId()
            );
        }

        $response = new Response();
        $response->setContent(json_encode($json));

        return $response;
    }
}