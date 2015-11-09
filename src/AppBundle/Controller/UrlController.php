<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Url;
use AppBundle\Form\UrlType;

/**
 * Url controller.
 *
 * @Route("/url")
 */
class UrlController extends Controller
{

    /**
     * Lists all Url entities.
     *
     * @Route("/", name="url")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Url')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Url entity.
     *
     * @Route("/", name="url_create")
     * @Method("POST")
     * @Template("AppBundle:Url:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Url();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('url_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Url entity.
     *
     * @param Url $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Url $entity)
    {
        $form = $this->createForm(new UrlType(), $entity, array(
            'action' => $this->generateUrl('url_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Url entity.
     *
     * @Route("/new", name="url_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Url();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Url entity.
     *
     * @Route("/{id}", name="url_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Url')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Url entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Url entity.
     *
     * @Route("/{id}/edit", name="url_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Url')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Url entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Url entity.
    *
    * @param Url $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Url $entity)
    {
        $form = $this->createForm(new UrlType(), $entity, array(
            'action' => $this->generateUrl('url_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Url entity.
     *
     * @Route("/{id}", name="url_update")
     * @Method("PUT")
     * @Template("AppBundle:Url:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Url')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Url entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('url_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Url entity.
     *
     * @Route("/{id}", name="url_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Url')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Url entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('url'));
    }

    /**
     * Creates a form to delete a Url entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('url_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
