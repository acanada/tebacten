<?php

namespace EtoxMicrome\EvidenciaEntidadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use EtoxMicrome\EvidenciaBundle\Form\EvidenciaType;
use EtoxMicrome\EvidenciaEntidadBundle\Form\AutocompleteSpeciesType;

class CompoundsController extends Controller
{


    public function indexAction($id_compuesto)
    {
        if (null == $id_compuesto) {
            $id_compuesto = $this->container->getParameter('etoxMicrome.compuesto_por_defecto');

            return new RedirectResponse($this->generateUrl('list_compounds', array('id_compuesto' => $id_compuesto)));
        }
        $em = $this->getDoctrine()->getEntityManager();

        //Anadimos el paginador
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage($this->container->getParameter('etoxMicrome.numero_evidencias_por_pagina'));
        $paginador->setMaxPagerItems($this->container->getParameter('etoxMicrome.numero_paginas_paginador'));

        $entidad = $em->getRepository('EntidadBundle:Entidad')->findOneById($id_compuesto);
        $compuesto = $entidad->getNombre();

        $evidenciasEntidades = $paginador->paginate(
            $em->getRepository('EvidenciaEntidadBundle:EvidenciaEntidad')->queryEvidenciasParaCompuesto($entidad)
        )->getResult();

        return $this->render(
            'EvidenciaEntidadBundle:Compounds:index.html.twig',array(
                'evidenciasEntidades' => $evidenciasEntidades,
                'id_compuesto' => $id_compuesto,
                'compuesto' => $compuesto,
                'paginador' => $paginador,
            )
        );
    }

    public function indexFromNameAction($name)
    {
        $alert="llega aqui";
        $id_compuesto = $this->container->getParameter('etoxMicrome.compuesto_por_defecto');
        //Pasamos el nombre del compuesto para obtener el id y redirigimos a evidencias_compuesto_id
        $em = $this->getDoctrine()->getManager();
        $entidad = $em->getRepository('EntidadBundle:Entidad')->findOneByNombre($name);
        if ($entidad==null){
            $id_compuesto = $this->container->getParameter('etoxMicrome.compuesto_por_defecto');
        }
        else{
            $id_compuesto=$entidad->getId();
        }

        return new RedirectResponse($this->generateUrl('evidencias_compuesto_id', array(
            'id_compuesto' => $id_compuesto
            )
        ));

    }

    public function actualizarAction($id_organismo,$id_evidencia)
    {
        //Tenemos que recuperar un array con todas las entidades que forman parte de la evidencia
        $em = $this->getDoctrine()->getManager();
        $entidades = $em->getRepository('EvidenciaEntidadBundle:EvidenciaEntidad')->findEntidadesFromEvidencia($id_evidencia)->getResult();;
        $evidencia = $em->getRepository('EvidenciaBundle:Evidencia')->findOneById($id_evidencia);
        if (!$evidencia)
        {
            throw $this->createNotFoundException('No existe esa evidencia');
        }

        /*$formEvidencia = $this->createFormBuilder($evidencia)
            ->add('code', 'text')
            ->add('texto', 'text')
            ->getForm();
        */

        $formEvidencia = $this->createForm(new EvidenciaType(), $evidencia);
        $request=$this->getRequest();
        if ($request->isMethod('POST')) {
            $formEvidencia->bind($request);

            if ($formEvidencia->isValid()) {
                // perform some action, such as saving the task to the database
                $em = $this->getDoctrine()->getEntityManager();
                $evidencia->setCurated(($evidencia->getCurated())+1);
                $evidencia->setUpdated(new \DateTime('now'));
                $em->persist($evidencia);
                $em->flush();
                return $this->redirect($this->generateUrl('list_species_id_organismo',array('id_organismo' => $id_organismo)));
            }
        }
        return $this->render('EvidenciaEntidadBundle:Species:edit.html.twig', array(
        'id_organismo' => $id_organismo,
        'formEvidencia' => $formEvidencia->createView(),
        'entidades' => $entidades,
        'evidencia' => $evidencia,

        ));
    }
}
