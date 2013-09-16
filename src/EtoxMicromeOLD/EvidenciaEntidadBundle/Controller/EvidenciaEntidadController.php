<?php

namespace EtoxMicrome\EvidenciaEntidadBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use EtoxMicrome\EvidenciaEntidadBundle\Entity\EvidenciaEntidad;
use EtoxMicrome\EvidenciaEntidadBundle\Form\EvidenciaEntidadType;

/**
 * EvidenciaEntidad controller.
 *
 * @Route("/evidenciaentidad")
 */
class EvidenciaEntidadController extends Controller
{
    /**
     * Lists all EvidenciaEntidad entities.
     *
     * @Route("/", name="evidenciaentidad")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EvidenciaEntidadBundle:EvidenciaEntidad')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new EvidenciaEntidad entity.
     *
     * @Route("/", name="evidenciaentidad_create")
     * @Method("POST")
     * @Template("EvidenciaEntidadBundle:EvidenciaEntidad:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new EvidenciaEntidad();
        $form = $this->createForm(new EvidenciaEntidadType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('evidenciaentidad_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new EvidenciaEntidad entity.
     *
     * @Route("/new", name="evidenciaentidad_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new EvidenciaEntidad();
        $form   = $this->createForm(new EvidenciaEntidadType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a EvidenciaEntidad entity.
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvidenciaEntidadBundle:EvidenciaEntidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EvidenciaEntidad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing EvidenciaEntidad entity.
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvidenciaEntidadBundle:EvidenciaEntidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EvidenciaEntidad entity.');
        }

        $editForm = $this->createForm(new EvidenciaEntidadType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing EvidenciaEntidad entity.
     *
     * @Route("/{id}", name="evidenciaentidad_update")
     * @Method("PUT")
     * @Template("EvidenciaEntidadBundle:EvidenciaEntidad:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvidenciaEntidadBundle:EvidenciaEntidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EvidenciaEntidad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new EvidenciaEntidadType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('evidenciaentidad_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a EvidenciaEntidad entity.
     *
     * @Route("/{id}", name="evidenciaentidad_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EvidenciaEntidadBundle:EvidenciaEntidad')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EvidenciaEntidad entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('evidenciaentidad'));
    }

    /**
     * Creates a form to delete a EvidenciaEntidad entity by id.
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