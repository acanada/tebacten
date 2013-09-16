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

use Doctrine\ORM\EntityManager,
    Doctrine\DBAL\Connection,
    AppKernel;

/**
 * Evidencia controller.
 *
 * @Route("/evidencia")
 */
class EvidenciaController extends Controller
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
    public function showAction($id_organismo, $id)
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
            'id_organismo' => $id_organismo,
        );
    }

    /**
     * Displays a form to edit an existing Evidencia entity.
     *
     * @Template()
     */
    public function editAction($id_organismo, $id)
    {
        $entidad=$id_organismo;
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvidenciaBundle:Evidencia')->find($id);

        if (!$entity) {
            //throw $this->createNotFoundException('Unable to find Evidencia entity.');
            //Seleccionamos como evidencia por defecto una evidencia que se encuentre este $id_organismo...
            $entity = $em->getRepository('EvidenciaEntidadBundle:EvidenciaEntidad')->findOneByEntidad($id_organismo);
            if(!$entity){
                throw $this->createNotFoundException('There is no evidence for that specie .');
            }
            $entity = $entity->getEvidencia();
        }

        $editForm = $this->createForm(new EvidenciaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        //Creamos tres arrays. neverCurated, onceCurated, twiceCurated que tienen las evidencias con 0, 1 y 2 curaciones de este organismo.
        //El $neverCuratedArray contiene en [0] un array con los primeros 30 ids de las evidencias que no han sido curadas todavía y en [1] el número total sin curar. Pasamos a la vista el $neverCuratedArray
        //$neverCurated=$neverCurated[0];
        //$numberNeverCurated=$neverCuratedArray[1];
        $connection = $em->getConnection();
        $numberCurated=0;
        $neverCuratedArray=$em->getRepository('EvidenciaEntidadBundle:EvidenciaEntidad')->getEvidenciasParaEntidadCuratedNumber($entidad, $numberCurated, $connection);
        $numberCurated=1;
        $onceCuratedArray=$em->getRepository('EvidenciaEntidadBundle:EvidenciaEntidad')->getEvidenciasParaEntidadCuratedNumber($entidad, $numberCurated, $connection);
        $numberCurated=2;
        $twiceCuratedArray=$em->getRepository('EvidenciaEntidadBundle:EvidenciaEntidad')->getEvidenciasParaEntidadCuratedNumber($entidad, $numberCurated, $connection);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'id_organismo' => $id_organismo,
            'neverCuratedArray' => $neverCuratedArray,
            'onceCuratedArray' => $onceCuratedArray,
            'twiceCuratedArray' => $twiceCuratedArray,
        );

        /*
        //En vez de mostrar la evidencia, tomamos la información de las Entidades que tiene asociadas a esa evidencia
        //También cogemos la información de la evidencia. Para ello:
        $em = $this->getDoctrine()->getManager();
        $evidencia = $em->getRepository('EvidenciaBundle:Evidencia')->findOneById($id);
        $evidenciasEntidades = $em->getRepository('EvidenciaEntidadBundle:EvidenciaEntidad')->findEvidenciasEntidadesOfIdEvidencia($id);
        $evidenciaEntidad = $em->getRepository('EvidenciaEntidadBundle:EvidenciaEntidad')->findOneByEvidencia($id);

        if (!$evidenciaEntidad) {
            throw $this->createNotFoundException('Unable to find Evidencia entity.');
        }

        $editForm = $this->createForm(new EvidenciaEntidadType(), $evidenciasEntidades);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $evidenciaEntidad,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'id_organismo' => $id_organismo,
        );
        */
    }

    /**
     * Edits an existing Evidencia entity.
     *
     */
    public function updateAction(Request $request, $id_organismo, $id)
    {
        $alert="llega aqui";
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
            //ld($editForm);
            if ($editForm->isValid()) {
                $children = $editForm->getChildren();
                foreach ($children as $childForm) {
                    $data = $childForm->getData();
                    //ld($data);
                }
                //Hacemos que el array $originalEvidenciaEntidad contenga únicamente las evidenciaEntidad que ya no están presentes porque han sido borradas.
                //Pero antes hacemos una copia por si lo necesitamos para añadir evidenciasEntidades
                $arrayEvidenciasEntidades=$originalEvidenciaEntidad;
                foreach ($evidencia->getEvidenciaEntidad() as $evidenciaEntidad) {
                    foreach ($originalEvidenciaEntidad as $key => $toDel) {
                        if ($toDel->getId() === $evidenciaEntidad->getId()) {
                            unset($originalEvidenciaEntidad[$key]);

                        }
                    }
                }
                // Eliminamos la evidenciaEntidad que ya no forma parte de esta evidencia:
                ld($originalEvidenciaEntidad);
                foreach ($originalEvidenciaEntidad as $evidenciaEntidad) {
                    // Because it is a ManyToOne relationship, remove the relationship like this

                    $em->remove($evidenciaEntidad);
                    // if you wanted to delete the Tag entirely, you can also do $em->remove($tag);
                }
                //Lo siguiente sería averiguar si hay alguna evidenciaEntidad que no estuviera en el array $arrayEvidenciasEntidades

                //$alert="antes de persistir";
                //ld($alert);
                $evidencia->setCurated($evidencia->getCurated()+1);
                $em->persist($evidencia);
                $em->flush();
                //$alert="despues de persistir";
                //ld($alert);
                return $this->redirect($this->generateUrl('evidencia_organismo_edit', array('id_organismo' => $id_organismo, 'id' => $id)));
            }
            $alert = "ooops";
            ldd($alert);
            $formErrors = $editForm->getErrors();
            $formErrors = $editForm->getErrorsAsString();


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
    public function deleteAction(Request $request, $id_organismo, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //Ojo!! antes de remover la evidencia tenemos que eliminar los EvidenciaDominio que tienen esa evidencia
            //Para ello hacemos:
            $evidenciaDominio = $em->getRepository('EvidenciaDominioBundle:EvidenciaDominio')->findOneById($id);
            if (!$evidenciaDominio) {
                throw $this->createNotFoundException('Unable to find its dominio.');
            }
                                    //$em->remove($evidenciaDominio);
                                    //$em->flush();
            //Ojo!! antes de remover la evidencia tenemos que eliminar las evidenciasEntidades que tienen esa evidencia
            //Para ello hacemos:
            $evidenciasEntidades = $em->getRepository('EvidenciaEntidadBundle:EvidenciaEntidad')->findEvidenciasEntidadesOfIdEvidencia($id);
            foreach ($evidenciasEntidades as $evidenciaEntidad){
                //Primero nos aseguramos de que si estamos quitando una evidenciaEntidad de un compuesto eliminar una posible entrada en la tabla compuesto
                $tipo=$evidenciaEntidad->getEntidad()->getTipo();
                if ($tipo=="compuesto"){
                    $compuesto= $em->getRepository('EntidadBundle:Compuesto')->findOneById($evidenciaEntidad->getId());
                    ldd($compuesto);
                }
                $em->remove($evidenciaEntidad);
            }
            $em->flush();
            //Ahora ya eliminamos la Evidencia
            $entity = $em->getRepository('EvidenciaBundle:Evidencia')->find($id);
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Evidencia entity.');
            }

            ld($entity);


            $em->remove($entity);
            $em->flush();
            $alert = "deleted";
            ld($alert);
            return $this->redirect($this->generateUrl('evidencias_organismo_id',array('id_organismo' => $id_organismo)));
        }
        $alert = "ooops";
        $formErrors = $form->getErrors();
        $formErrors = $form->getErrorsAsString();
        ldd($formErrors);
        return $this->redirect($this->generateUrl('homepage'));
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
