<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }

    /**
     * Finds and displays a Url entity.
     *
     * @Route("/{shortcode}", name="redirect_shortcode")
     * @Method("GET")
     * @Template()
     */
    public function redirectAction($shortcode)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Url')->findOneByShortcode($shortcode);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Url entity.');
        }

        return $this->render('default/redirect.html.twig', array(
            'entity' => $entity,
        ));
    }
}
