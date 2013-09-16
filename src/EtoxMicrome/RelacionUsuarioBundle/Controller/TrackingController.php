<?php

namespace EtoxMicrome\RelacionUsuarioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TrackingController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction()
    {
        return $this->render('RelacionUsuarioBundle:Tracking:index.html.twig');
    }

    public function trackByUserAction($username)
    {
        $em = $this->getDoctrine()->getEntityManager();

        //Anadimos el paginador
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage($this->container->getParameter('etoxMicrome.numero_cambios_por_pagina'));
        $paginador->setMaxPagerItems($this->container->getParameter('etoxMicrome.numero_paginas_paginador'));



        $arrayChanges = $paginador->paginate($em->getRepository('RelacionUsuarioBundle:RelacionUsuario')->getChangesByUser($username));
        //ldd($arrayChanges);
        return $this->render(
            'RelacionUsuarioBundle:Tracking:userChangesIndex.html.twig',array(
                'username' => $username,
                'paginador' => $paginador,
                'arrayChanges' => $arrayChanges,
                #'autocompleteSpeciesForm' => $autocompleteSpeciesForm->createView(),
            )
        );
    }

    public function trackByUserAndDateAction($username, $startDate, $endDate)
    {
        $em = $this->getDoctrine()->getEntityManager();

        //Anadimos el paginador
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage($this->container->getParameter('etoxMicrome.numero_cambios_por_pagina'));
        $paginador->setMaxPagerItems($this->container->getParameter('etoxMicrome.numero_paginas_paginador'));



        $arrayChanges = $paginador->paginate($em->getRepository('RelacionUsuarioBundle:RelacionUsuario')->getChangesByUserDates($username,$startDate,$endDate));
        //ldd($arrayChanges);
        return $this->render(
            'RelacionUsuarioBundle:Tracking:userDatesChangesIndex.html.twig',array(
                'username' => $username,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'paginador' => $paginador,
                'arrayChanges' => $arrayChanges,
                #'autocompleteSpeciesForm' => $autocompleteSpeciesForm->createView(),
            )
        );
    }

    public function trackByEntityAction($entity)
    {
        $em = $this->getDoctrine()->getEntityManager();

        //Anadimos el paginador
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage($this->container->getParameter('etoxMicrome.numero_cambios_por_pagina'));
        $paginador->setMaxPagerItems($this->container->getParameter('etoxMicrome.numero_paginas_paginador'));



        $arrayChanges = $paginador->paginate($em->getRepository('RelacionUsuarioBundle:RelacionUsuario')->getChangesByEntity($entity));
        //ldd($arrayChanges);
        return $this->render(
            'RelacionUsuarioBundle:Tracking:entityChangesIndex.html.twig',array(
                'entity' => $entity,
                'paginador' => $paginador,
                'arrayChanges' => $arrayChanges,
                #'autocompleteSpeciesForm' => $autocompleteSpeciesForm->createView(),
            )
        );
    }

    public function trackByEntityAndDateAction($entity, $startDate, $endDate)
    {
        $em = $this->getDoctrine()->getEntityManager();

        //Anadimos el paginador
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage($this->container->getParameter('etoxMicrome.numero_cambios_por_pagina'));
        $paginador->setMaxPagerItems($this->container->getParameter('etoxMicrome.numero_paginas_paginador'));



        $arrayChanges = $paginador->paginate($em->getRepository('RelacionUsuarioBundle:RelacionUsuario')->getChangesByEntityDates($entity,$startDate,$endDate));
        //ld($arrayChanges);
        return $this->render(
            'RelacionUsuarioBundle:Tracking:entityDatesChangesIndex.html.twig',array(
                'entity' => $entity,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'paginador' => $paginador,
                'arrayChanges' => $arrayChanges,
                #'autocompleteSpeciesForm' => $autocompleteSpeciesForm->createView(),
            )
        );
    }

    public function trackByEvidenceAction($evidence)
    {
        $em = $this->getDoctrine()->getEntityManager();

        //Anadimos el paginador
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage($this->container->getParameter('etoxMicrome.numero_cambios_por_pagina'));
        $paginador->setMaxPagerItems($this->container->getParameter('etoxMicrome.numero_paginas_paginador'));



        $arrayChanges = $paginador->paginate($em->getRepository('RelacionUsuarioBundle:RelacionUsuario')->getChangesByEvidence($evidence));
        //ldd($arrayChanges);
        return $this->render(
            'RelacionUsuarioBundle:Tracking:evidenceChangesIndex.html.twig',array(
                'evidence' => $evidence,
                'paginador' => $paginador,
                'arrayChanges' => $arrayChanges,
                #'autocompleteSpeciesForm' => $autocompleteSpeciesForm->createView(),
            )
        );
    }

    public function trackByEvidenceAndDateAction($evidence, $startDate, $endDate)
    {
        $em = $this->getDoctrine()->getEntityManager();

        //Anadimos el paginador
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage($this->container->getParameter('etoxMicrome.numero_cambios_por_pagina'));
        $paginador->setMaxPagerItems($this->container->getParameter('etoxMicrome.numero_paginas_paginador'));



        $arrayChanges = $paginador->paginate($em->getRepository('RelacionUsuarioBundle:RelacionUsuario')->getChangesByEvidenceDates($evidence,$startDate,$endDate));
        //ld($arrayChanges);
        return $this->render(
            'RelacionUsuarioBundle:Tracking:evidenceDatesChangesIndex.html.twig',array(
                'evidence' => $evidence,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'paginador' => $paginador,
                'arrayChanges' => $arrayChanges,
                #'autocompleteSpeciesForm' => $autocompleteSpeciesForm->createView(),
            )
        );
    }
}
