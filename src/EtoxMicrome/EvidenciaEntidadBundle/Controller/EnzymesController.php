<?php

namespace EtoxMicrome\EvidenciaEntidadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use EtoxMicrome\EvidenciaBundle\Form\EvidenciaType;
use EtoxMicrome\EvidenciaEntidadBundle\Form\AutocompleteSpeciesType;

class EnzymesController extends Controller
{


    public function indexAction($id_enzima)
    {
        if (null == $id_enzima) {
            $id_enzima = $this->container->getParameter('etoxMicrome.enzima_por_defecto');

            return new RedirectResponse($this->generateUrl('list_enzymes', array('id_enzima' => $id_enzima)));
        }
        $em = $this->getDoctrine()->getEntityManager();

        //Anadimos el paginador
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage($this->container->getParameter('etoxMicrome.numero_evidencias_por_pagina'));
        $paginador->setMaxPagerItems($this->container->getParameter('etoxMicrome.numero_paginas_paginador'));

        $entidad = $em->getRepository('EntidadBundle:Entidad')->findOneById($id_enzima);
        $enzima = $entidad->getNombre();
        //ld($organismo);
        //$evidenciasOrganismos = $em->getRepository('EvidenciaBundle:EvidenciasOrganismos')->findEvidenciasParaOrganismo($organismo); Al anadir el paginador se refactoriza por:
        $arrayEvidencias = $paginador->paginate(
            $em->getRepository('EvidenciaEntidadBundle:EvidenciaEntidad')->queryEvidenciasParaEntidad($entidad)
        )->getResult();
        //Pasamos el array de evidencias a un array con objetos evidencia
        $arrayObjetosEvidencia=array();
        foreach($arrayEvidencias as $evidencia){
            $objeto=$em->getRepository('EvidenciaBundle:Evidencia')->findOneById($evidencia);
            array_push($arrayObjetosEvidencia, $objeto);
        }
        //ld($arrayObjetosEvidencia);
        return $this->render(
            'EvidenciaEntidadBundle:Enzymes:index.html.twig',array(
                'arrayEvidencias' => $arrayObjetosEvidencia,
                'id_enzima' => $id_enzima,
                'enzima' => $enzima,
                'paginador' => $paginador,
            )
        );
    }

    public function indexFromNameAction($name)
    {
        $alert="llega aqui";
        $id_organismo = $this->container->getParameter('etoxMicrome.enzima_por_defecto');
        //Pasamos el name del organismo para obtener el id y redirigimos a evidencias_organismo_id
        $em = $this->getDoctrine()->getManager();
        $entidad = $em->getRepository('EntidadBundle:Entidad')->findOneByNombre($name);
        if ($entidad==null){
            $id_enzima = $this->container->getParameter('etoxMicrome.enzima_por_defecto');
        }
        else{
            $id_enzima=$entidad->getId();
        }

        return new RedirectResponse($this->generateUrl('evidencias_enzima_id', array(
            'id_enzima' => $id_enzima
            )
        ));

    }

    public function indexFromNameAdvanceSearchAction($urlParam,$name)
    {
        $alert="Llega aqui";
        $em = $this->getDoctrine()->getManager();
        $enzima=$name;
        $id_enzima=$em->getRepository('EntidadBundle:Enzima')->getEnzimeIdFromName($name);
        //ld($id_enzima);
        //ld($urlParam);//En $urlParam hay algo como: compound=Atopobium&Enzyme=Amoxicillin-clavulanate potassium. Hacemos explode por & y obtenemos los par�metros de la b�squeda
        $searchParams=explode("&",$urlParam);
        $arrayParameters=array();
        foreach($searchParams as $param){
            $type_value_array=explode("=",$param);
            array_push($arrayParameters,$type_value_array);
        }
        //En $arrayParameters tenemos un array que contiene tantos arrays como par�metros para la busqueda avanzada
        //ld($arrayParameters);
        //Tenemos que generar la consulta con estos datos que tenemos en el $specie y $arrayParameters

        //ld($arrayParameters);

        $arrayEvidencias=$em->getRepository('EvidenciaEntidadBundle:EvidenciaEntidad')->queryEvidenciasAdvanceSearch($enzima,$arrayParameters);
        //Anadimos el paginador
        //ld($arrayEvidencias);
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage($this->container->getParameter('etoxMicrome.numero_evidencias_por_pagina'));
        $paginador->setMaxPagerItems($this->container->getParameter('etoxMicrome.numero_paginas_paginador'));

         //$evidenciasEntidades = $paginador->paginate($em->getRepository('EvidenciaEntidadBundle:EvidenciaEntidad')->queryEvidenciasEntidadesFromEvidencias($arrayEvidencias));

        //Recorremos el arrayEvidencias para generar un array de objetos EvidenciaEntidad con el que generar el index
        $evidenciasEntidades=$em->getRepository('EvidenciaEntidadBundle:EvidenciaEntidad')->queryEvidenciasEntidadesFromEvidencias($arrayEvidencias);
        //ld($evidenciasEntidades);
        $arrayEvidencias=array();
        if (count($evidenciasEntidades)!=0){
            foreach ($evidenciasEntidades as $evidencia){
               $evidenciaObj=$evidencia->getEvidencia();
               array_push($arrayEvidencias, $evidenciaObj);
            }
        }
        $arrayEvidencias=array_unique($arrayEvidencias);
        return $this->render(
            'EvidenciaEntidadBundle:Enzymes:index.advanceSearch.html.twig',array(
                'arrayEvidencias' => $arrayEvidencias,
                'id_enzima' => $id_enzima,
                'enzima' => $enzima,
                'paginador' => $paginador,
                'arrayParameters' => $arrayParameters,
                #'autocompleteSpeciesForm' => $autocompleteSpeciesForm->createView(),
            )
        );

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
