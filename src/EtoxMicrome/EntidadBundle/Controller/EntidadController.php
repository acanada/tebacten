<?php

namespace EtoxMicrome\EntidadBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use EtoxMicrome\EntidadBundle\Entity\Entidad;
use EtoxMicrome\EntidadBundle\Form\EntidadType;

/**
 * Entidad controller.
 *
 * @Route("/entidad")
 */
class EntidadController extends Controller
{
    /**
     * Lists all Entidad entities.
     *
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EntidadBundle:Entidad')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Entidad entity.
     *
     * @Route("/", name="entidad_create")
     * @Method("POST")
     * @Template("EntidadBundle:Entidad:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Entidad();
        $form = $this->createForm(new EntidadType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('entidad_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Entidad entity.
     *
     * @Route("/new", name="entidad_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Entidad();
        $form   = $this->createForm(new EntidadType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Entidad entity.
     *
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EntidadBundle:Entidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entidad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Entidad entity.
     *
     * @Route("/{id}/edit", name="entidad_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EntidadBundle:Entidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entidad entity.');
        }

        $editForm = $this->createForm(new EntidadType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Entidad entity.
     *
     * @Route("/{id}", name="entidad_update")
     * @Method("PUT")
     * @Template("EntidadBundle:Entidad:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EntidadBundle:Entidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entidad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new EntidadType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('entidad_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Entidad entity.
     *
     * @Route("/{id}", name="entidad_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EntidadBundle:Entidad')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Entidad entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('entidad'));
    }

    /**
     * Creates a form to delete a Entidad entity by id.
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

    public function autocompleteAction()
    {
        //$connection = $this->getDoctrine()->getConnection();
        $user = $this->getDoctrine()->getConnection()->getUsername();
        $password = $this->getDoctrine()->getConnection()->getPassword();
        $host = $this->getDoctrine()->getConnection()->getHost();

        $request = $this->getRequest();
        $term = $request->query->get('term');

        $conn = mysql_connect ($host, $user, $password);
        mysql_select_db("EtoxMicromeTebacten", $conn);
        mysql_query("SET NAMES 'utf8'");
        $selectSQL="select distinct(nombre), id from Entidad where lower(nombre) like lower('%$term%')";
        #print $selectSQL;
        $result= mysql_query($selectSQL);
        $arr=array();
        while ($row = mysql_fetch_row($result)){
        	#$idEnzyme=$row[0];
        	$textminingEnzymeName=$row[0];
        	$id=$row[1];
        	$arrayTmp=array("label"=>$textminingEnzymeName,"value"=>$textminingEnzymeName);
        	$arr[]=$arrayTmp;
        }
        $jsonString = json_encode($arr);
        print $jsonString;
        exit();
    }

    public function autocomplete_userAction()
    {
        //$connection = $this->getDoctrine()->getConnection();
        $user = $this->getDoctrine()->getConnection()->getUsername();
        $password = $this->getDoctrine()->getConnection()->getPassword();
        $host = $this->getDoctrine()->getConnection()->getHost();

        $request = $this->getRequest();
        $term = $request->query->get('term');

        $conn = mysql_connect ($host, $user, $password);
        mysql_select_db("EtoxMicromeTebacten", $conn);
        mysql_query("SET NAMES 'utf8'");
        $selectSQL="select distinct(username), id from fos_user where lower(username) like lower('%$term%')";
        #print $selectSQL;
        $result= mysql_query($selectSQL);
        $arr=array();
        while ($row = mysql_fetch_row($result)){
        	#$idEnzyme=$row[0];
        	$username=$row[0];
        	$id=$row[1];
        	$arrayTmp=array("label"=>$username,"value"=>$username);
        	$arr[]=$arrayTmp;
        }
        $jsonString = json_encode($arr);
        print $jsonString;
        exit();
    }

    public function getChebiIDsAction(Request $request){
        /* Asegurar que la solicitud sea AJAX
        if (!$request->isXmlHttpRequest())
            $response = new Response(json_encode(array('error'=>'Only AJAX requests. Sorry.')));
            $response->headers->set('Content-Type', 'application/json');
            return $response;

        */
        /* si entra por POST o GET la variable sfUserId, continuar */
        if($request->get('chebiName')){

            $chebiName=$request->query->get('chebiName');
            $arrayChebiIds=array();
            $a = $chebiName;
            $b = 'CHEBI NAME';
            $c = 20;
            $d="ALL";
            try{
                $client = new \SoapClient("http://www.ebi.ac.uk/webservices/chebi/2.0/webservice?wsdl");
                $entities = $client->getLiteEntity(array("search" => $a, "searchCategory" => $b, "maximumResults" => $c, "stars" => $d));
                //print_r($entities->return);

                //Comprobamos si el objeto resultado de la búsqueda viene vacío y en ese caso devolvemos un json con un array vacío
                if((count(get_object_vars($entities->return)) == 0))
                {
                    $arrayResponse=array();
                    $jsonString = json_encode($arrayResponse);
                    $response = new Response($jsonString);
                    $response->headers->set('Content-Type', 'application/json');

                    return $response;
                }
                else
                {
                    $listElements=$entities->return->ListElement;
                    //print_r($listElements);//WARNING!!! listElements puede ser un array con objetos o un objeto
                    if (is_array($listElements)){
                        //gestionamos array
                        foreach($listElements as $element){
                            $chebiId=$element->chebiId;
                            array_push($arrayChebiIds, $chebiId);
                        }
                    }
                    else{
                        //gestionamos objeto
                        $chebiId=$listElements->chebiId;
                        array_push($arrayChebiIds, $chebiId);
                    }
                    //print_r($arrayChebiIds);
                    $jsonString = json_encode($arrayChebiIds);
                    $response = new Response($jsonString);
                    $response->headers->set('Content-Type', 'application/json');

                    return $response;
                }

            } catch(Exception $e){
                $arrayResponse=array();
                $jsonString = json_encode($arrayResponse);
                $response = new Response($jsonString);
                $response->headers->set('Content-Type', 'application/json');

                return $response;
            }
            //Si por cualquier caso llega hasta aqui, devolvemos un json vacio.
            $arrayResponse=array();
            $jsonString = json_encode($arrayResponse);
            $response = new Response($jsonString);
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }
    }

    public function getTaxIDAction(Request $request){
        /* Asegurar que la solicitud sea AJAX
        if (!$request->isXmlHttpRequest())
            $response = new Response(json_encode(array('error'=>'Only AJAX requests. Sorry.')));
            $response->headers->set('Content-Type', 'application/json');
            return $response;

        */
        /* si entra por POST o GET la variable sfUserId, continuar */
        if($request->get('textminingOrganismName')){

            $chebiName=$request->query->get('chebiName');
            $arrayChebiIds=array();
            $a = $chebiName;
            $b = 'CHEBI NAME';
            $c = 20;
            $d="ALL";
            try{
                $client = new \SoapClient("http://www.ebi.ac.uk/webservices/chebi/2.0/webservice?wsdl");
                //$client->getLiteEntity($a, $b, $c, $d);
                //$entities = $client->__soapCall("getLiteEntity", array("search" => $a, "searchCategory" => $b, "maximumResults" => $c, "stars" => $d));
                $entities = $client->getLiteEntity(array("search" => $a, "searchCategory" => $b, "maximumResults" => $c, "stars" => $d));

                //print_r($entities);

                $arrayEntities = get_object_vars($entities);
                $arrayEn=get_object_vars($arrayEntities['return']);
                if (isset($arrayEn['ListElement'])){
                    $arrayListObjs=$arrayEn['ListElement'];
                    foreach($arrayListObjs as $obj){
                        $chebiId=$obj->chebiId;
                        array_push($arrayChebiIds, $chebiId);
                    }

                    $jsonString = json_encode($arrayChebiIds);
                    $response = new Response($jsonString);
                    $response->headers->set('Content-Type', 'application/json');

                    return $response;
                }
            } catch(Exception $e){
                $arrayResponse=array();
                $jsonString = json_encode($arrayResponse);
                $response = new Response($jsonString);
                $response->headers->set('Content-Type', 'application/json');

                return $response;
            }
            $arrayResponse=array();
            $jsonString = json_encode($arrayResponse);
            $response = new Response($jsonString);
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }
    }
}
