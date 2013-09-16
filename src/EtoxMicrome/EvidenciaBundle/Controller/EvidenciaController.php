<?php

namespace EtoxMicrome\EvidenciaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use EtoxMicrome\EvidenciaBundle\Entity\Evidencia;
use EtoxMicrome\EvidenciaEntidadBundle\Entity\EvidenciaEntidad;

use EtoxMicrome\EvidenciaBundle\Form\EvidenciaType;
use EtoxMicrome\EvidenciaEntidadBundle\Form\EvidenciaEntidadType;
use EtoxMicrome\RelacionBundle\Entity\Relacion;
use EtoxMicrome\RelacionBundle\Entity\TipoRelacion;

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
        //ld($entity->getEvidenciaEntidad()->getValues());
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

        $pubmedURL=$entity->getOrigen()->getUrl();//Tenemos la URL del pmid de esta evidencia y generamos un array con todas las evidencias que contienen este mismo origen.url para mostrarlas. Para ello hacemos:
        $arrayEvidenciasMismoPubmed=$em->getRepository('OrigenBundle:Origen')->getEvidenciasParaOrigenURL($pubmedURL);

        //We create an array with all the possibilities, type of relations, that can be established between two EvidenciasEntidades!!
        $arrayRelations = $em->getRepository('RelacionBundle:TipoRelacion')->getTipoRelaciones();

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'id_organismo' => $id_organismo,
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
                //ld($originalEvidenciaEntidad);
                foreach ($originalEvidenciaEntidad as $evidenciaEntidad) {
                    // Because it is a ManyToOne relationship, remove the relationship like this

                    $em->remove($evidenciaEntidad);
                    // if you wanted to delete the Tag entirely, you can also do $em->remove($tag);
                }
                //Lo siguiente sería averiguar si hay alguna evidenciaEntidad que no estuviera en el array $arrayEvidenciasEntidades

                $alert="antes de persistir";
                //$user=$this->getUser()->getId();
                //ldd($user);
                $evidencia->setCurated($evidencia->getCurated()+1);
                $em->persist($evidencia);
                $em->flush();
                //$alert="despues de persistir";
                //ld($alert);
                return $this->redirect($this->generateUrl('evidencia_organismo_edit', array('id_organismo' => $id_organismo, 'id' => $id)));
            }
            $alert = "ooops";
            //ldd($alert);
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

    public function relationsAction($id_entidad, $id, $entity_type)
    {
        $alert="llega aqui";
        $entidad=$id_entidad;
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EvidenciaBundle:Evidencia')->find($id);
        //ld($entity->getEvidenciaEntidad()->getValues());
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

        $connection = $em->getConnection();
        //We create an array with all the possibilities, type of relations, that can be established between two EvidenciasEntidades!!
        $arrayRelations = $em->getRepository('RelacionBundle:TipoRelacion')->getTipoRelaciones();

        $arrayTableRelations=$em->getRepository('RelacionBundle:Relacion')->crearTablaRelaciones($entity);
        //ld($arrayTableRelations);
        return $this->render(
            "EvidenciaBundle:Evidencia:relations.html.twig",
            array(
                'entity'      => $entity,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
                'id_entidad' => $id_entidad,
                'id_evidencia' => $id,
                'arrayRelations' => $arrayRelations,
                'arrayTableRelations' => $arrayTableRelations,
                'entity_type' => $entity_type,
            )
        );
    }

    public function saveRelationsAction(Request $request, $entity_type, $entity_id, $id_evidence){
        $user_id=$this->getUser()->getId();
        //ldd($user_id);
        $em = $this->getDoctrine()->getManager();
        $postedData=$_POST;
        //ld($postedData);
        //En $postedData tenemos un array con tantas posiciones como opciones hay en los select. Si una opcion está seleccionada,
        //Recorremos el array buscando qué relaciones han sido establecidas
        foreach($postedData as $key => $val){
            if ($val!==""){
                //ld($key); //Tenemos una relacion establecida que es un string con algo como "14916|14916|is a", extraemos el contenido.
                //ld($val);
                $arrayRelacion=explode("-",$key);
                $arrayEvidencias=$arrayRelacion[1];
                //ld($arrayEvidencias);
                $arrayEvidencias=explode("|",$arrayEvidencias);
                $evidenciaEntidadOrigen_id=(int)$arrayEvidencias[0];
                //ld($evidenciaEntidadOrigen_id);
                //$evidenciaEntidadOrigen = $em->getRepository('EvidenciaEntidadBundle:EvidenciaEntidad')->findEvidenciaEntidadFromId($evidenciaEntidadOrigen_id);

                //$evidenciaEntidadOrigen = $em->getRepository('EvidenciaEntidadBundle:EvidenciaEntidad')->findOneById($evidenciaEntidadOrigen_id);

                $evidenciaEntidadDestino_id=(int)$arrayEvidencias[1];
                //ld($evidenciaEntidadDestino_id);
                //$evidenciaEntidadDestino = $em->getRepository('EvidenciaEntidadBundle:EvidenciaEntidad')->findEvidenciaEntidadFromId($evidenciaEntidadDestino_id);
                //ld($evidenciaEntidadDestino->getId());

                $tipoRelacion=$val;
                //ld($tipoRelacion);
                //Tenemos que ver cuál es el id de la relación ya que lo que se guarda es el tipoRelacionId. Para ello hacemos:
                $tipoRelacion_id = $em->getRepository('RelacionBundle:TipoRelacion')->getTipoRelacionId($tipoRelacion);
                //ldd($tipoRelacion);
                //$tipoRelacion_id=$tipoRelacion->getId();

                //Ya tenemos todos los datos de esta Relación y vamos a añadirla/modificarla.
                $em->getRepository('RelacionBundle:Relacion')->anadirModificarRelacion($evidenciaEntidadOrigen_id, $evidenciaEntidadDestino_id, $tipoRelacion_id, $user_id);
            }
        }
        //return $this->redirect($this->generateUrl('close_window'));
        //return $this->render('EvidenciaBundle:Default:close.html.twig');
        if($entity_type=="specie"){
            return $this->redirect($this->generateUrl('evidencia_organismo_edit',array('id_organismo' => $entity_id, 'id' => $id_evidence)));
        }
        elseif($entity_type=="enzyme"){
            return $this->redirect($this->generateUrl('evidencia_enzima_edit',array('id_enzima' => $entity_id, 'id' => $id_evidence)));
        }
        elseif($entity_type=="compound"){
            return $this->redirect($this->generateUrl('evidencia_compuesto_edit',array('id_compuesto' => $entity_id, 'id' => $id_evidence)));
        }
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
