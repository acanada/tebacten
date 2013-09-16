<?php

namespace EtoxMicrome\EvidenciaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use EtoxMicrome\EvidenciaBundle\Entity\Evidencia;
use EtoxMicrome\EvidenciaBundle\Form\EvidenciaType;
use EtoxMicrome\EvidenciaEntidadBundle\Form\EvidenciaEntidadType;
use EtoxMicrome\RelacionBundle\Entity\Relacion;
use EtoxMicrome\RelacionBundle\Entity\TipoRelacion;

/**
 * Evidencia controller.
 *
 * @Route("/evidencia")
 */
class EnzimaController extends Controller
{
    /**
     * Lists all Evidencia entities.
     *
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EvidenciaBundle:Evidencia')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Evidencia entity.
     *
     * @Route("/", name="evidencia_create")
     * @Method("POST")
     * @Template("EvidenciaBundle:Evidencia:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Evidencia();
        $form = $this->createForm(new EvidenciaType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('evidencia_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Evidencia entity.
     *
     * @Route("/new", name="evidencia_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Evidencia();
        $form   = $this->createForm(new EvidenciaType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Evidencia entity.
     *
     * @Template()
     */
    public function showAction($id_enzima, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvidenciaBundle:Evidencia')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Evidencia entity for evidencia '.$id);
        }
        $evidenciasEntidades = $em->getRepository('EvidenciaEntidadBundle:EvidenciaEntidad')->findEvidenciasEntidadesOfIdEvidencia($id);
        if (!$evidenciasEntidades) {
            throw $this->createNotFoundException('Unable to find EvidenciasEntidades related to evidencia $id.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'evidenciasEntidades' => $evidenciasEntidades,
            'delete_form' => $deleteForm->createView(),
            'id_enzima' => $id_enzima,
        );
    }

    /**
     * Displays a form to edit an existing Evidencia entity.
     *
     * @Template()
     */
    public function editAction($id_enzima, $id)
    {
        $entidad=$id_enzima;
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvidenciaBundle:Evidencia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Evidencia entity.');
        }

        $editForm = $this->createForm(new EvidenciaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        //Creamos tres arrays. neverCurated, onceCurated, twiceCurated que tienen las evidencias con 0, 1 y 2 curaciones de esta enzima.
        //El $neverCuratedArray contiene en [0] un array con los primeros 30 ids de las evidencias de esa enzima que no han sido curadas todavía y en [1] el número total sin curar. Pasamos a la vista el $neverCuratedArray.
        //$neverCurated=$neverCurated[0];
        //$numberNeverCurated=$neverCuratedArray[1];
        $connection = $em->getConnection();
        $numberCurated=0;
        $neverCuratedArray=$em->getRepository('EvidenciaEntidadBundle:EvidenciaEntidad')->getEvidenciasParaEntidadCuratedNumber($entidad, $numberCurated, $connection);
        $numberCurated=1;
        $onceCuratedArray=$em->getRepository('EvidenciaEntidadBundle:EvidenciaEntidad')->getEvidenciasParaEntidadCuratedNumber($entidad, $numberCurated, $connection);
        $numberCurated=2;
        $twiceCuratedArray=$em->getRepository('EvidenciaEntidadBundle:EvidenciaEntidad')->getEvidenciasParaEntidadCuratedNumber($entidad, $numberCurated, $connection);

        $pubmedURL=$entity->getOrigen()->getUrl();//Tenemos la URL del pmid de esta evidencia y generamos un array con todas las evidencias que contienen este mismo origen.url para mostrarlas. Para ello hacemos:
        $arrayEvidenciasMismoPubmed=$em->getRepository('OrigenBundle:Origen')->getEvidenciasParaOrigenURL($pubmedURL);

        //We create an array with all the possibilities, type of relations, that can be established between two EvidenciasEntidades!!
        $arrayRelations = $em->getRepository('RelacionBundle:TipoRelacion')->getTipoRelaciones();

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'id_enzima' => $id_enzima,
            'neverCuratedArray' => $neverCuratedArray,
            'onceCuratedArray' => $onceCuratedArray,
            'twiceCuratedArray' => $twiceCuratedArray,
            'arrayEvidenciasMismoPubmed' => $arrayEvidenciasMismoPubmed,
            'arrayRelations' => $arrayRelations,
        );
    }

    /**
     * Edits an existing Evidencia entity.
     *
     */
    public function updateAction(Request $request, $id_enzima, $id)
    {

        $arrayEvidenciaEntidadAnadir = array();
        $em = $this->getDoctrine()->getManager();

        $evidencia = $em->getRepository('EvidenciaBundle:Evidencia')->find($id);
        if (!$evidencia) {
            throw $this->createNotFoundException('Unable to find Evidencia entity.');
        }

        //Creamos un array con las evidenciasEntidades actuales en la base de datos.
        $originalEvidenciaEntidad = array();
        foreach ($evidencia->getEvidenciaEntidad() as $evidenciaEntidad) {
            $originalEvidenciaEntidad[] = $evidenciaEntidad;
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new EvidenciaType(), $evidencia);
        if ($this->getRequest()->getMethod() == 'POST') {
            $editForm->bindRequest($this->getRequest());
            ld($editForm);
            if ($editForm->isValid()) {
                // hacemos que el array $originalEvidenciaEntidad contenga únicamente las evidenciaEntidad que ya no están presentes porque han sido borradas.
                foreach ($evidencia->getEvidenciaEntidad() as $evidenciaEntidad) {
                    foreach ($originalEvidenciaEntidad as $key => $toDel) {
                        if ($toDel->getId() === $evidenciaEntidad->getId()) {
                            unset($originalEvidenciaEntidad[$key]);

                        }
                    }
                }
                // Eliminamos la evidenciaEntidad que ya no forma parte de esta evidencia:

                foreach ($originalEvidenciaEntidad as $evidenciaEntidad) {
                    // Because it is a ManyToOne relationship, remove the relationship like this
                    $em->remove($evidenciaEntidad);
                    // if you wanted to delete the Tag entirely, you can also do $em->remove($tag);
                }

                $evidencia->setCurated($evidencia->getCurated()+1);
                $em->persist($evidencia);
                $em->flush();
                $alert = "redirigir";
                ld($alert);
                return $this->redirect($this->generateUrl('evidencia_enzima_edit', array('id_enzima' => $id_enzima, 'id' => $id)));
            }
            $formErrors = $editForm->getErrors();
            $formErrors = $editForm->getErrorsAsString();

            $alert = "ooops";
            //return $this->redirect($this->generateUrl('evidencia_update_error', array('id' => $id, 'editForm' => $editForm)));

            ldd($alert);
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'id_organismo' => $id_organismo,
        );
    }

    public function errorAction(Request $request, $id,$editForm)
    {
        ldd($editForm);
        return $this->render('EvidenciaBundle:Evidencia:error.html.twig', array(
            'id' => $id,
            'edit_form' => $edit_form->createView()
            ));
    }


    /**
     * Deletes a Evidencia entity.
     *
     * @Route("/{id}", name="evidencia_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EvidenciaBundle:Evidencia')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Evidencia entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('evidencia'));
    }

    /**
     * Creates a form to delete a Evidencia entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
