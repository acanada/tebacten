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

/**
 * Default controller.
 */
class DefaultController extends Controller
{
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvidenciaBundle:Evidencia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Evidencia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        return $this->render('EvidenciaBundle:Default:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Evidencia entity.
     *
     * @Template()
     */
    public function editAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvidenciaBundle:Evidencia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Evidencia entity.');
        }

        $editForm = $this->createForm(new EvidenciaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);


        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Evidencia entity.
     *
     * @Template("EvidenciaBundle:Evidencia:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvidenciaBundle:Evidencia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Evidencia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new EvidenciaType(), $entity);
        if ($this->getRequest()->getMethod() == 'POST') {
            $editForm->bindRequest($this->getRequest());
            if ($editForm->isValid()) {
                $em->persist($entity);
                $em->flush();
                return $this->redirect($this->generateUrl('evidencia_show', array('id' => $id)));
            }
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
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
