<?php

namespace EtoxMicrome\OrigenBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use EtoxMicrome\OrigenBundle\Entity\Origen;
use EtoxMicrome\OrigenBundle\Form\OrigenType;

/**
 * Origen controller.
 *
 * @Route("/origen")
 */
class OrigenController extends Controller
{
    /**
     * Lists all Origen entities.
     *
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('OrigenBundle:Origen')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Origen entity.
     *
     * @Route("/", name="origen_create")
     * @Method("POST")
     * @Template("OrigenBundle:Origen:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Origen();
        $form = $this->createForm(new OrigenType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('origen_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Origen entity.
     *
     * @Route("/new", name="origen_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Origen();
        $form   = $this->createForm(new OrigenType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Origen entity.
     *
     * @Route("/{id}", name="origen_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OrigenBundle:Origen')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Origen entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Origen entity.
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OrigenBundle:Origen')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Origen entity.');
        }

        $editForm = $this->createForm(new OrigenType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Origen entity.
     *
     * @Route("/{id}", name="origen_update")
     * @Method("PUT")
     * @Template("OrigenBundle:Origen:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OrigenBundle:Origen')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Origen entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new OrigenType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('origen_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Origen entity.
     *
     * @Route("/{id}", name="origen_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('OrigenBundle:Origen')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Origen entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('origen'));
    }

    /**
     * Creates a form to delete a Origen entity by id.
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
