<?php

namespace Api\SymfBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Api\SymfBundle\Entity\Events;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

	/**
     * @Route("api/events/{id}", name="events_view")
     */
    public function viewAction(Events $events)
    {
    	
        $data = $this->get('jms_serializer')->serialize($events, 'json');

        $response = new Response($data);

        $response->headers->set('Content-Type', 'application/json');

        return $response;
        // return $this->render('@ApiSymfBundle/Default/index.html.twig');
    }

      /**
     * @Route("api/events", name="events_create")
     * @Method({"POST"})
     */
    public function createAction(Request $request)
    {

        $data = $request->getContent();
        $events = $this->get('jms_serializer')->deserialize($data, 'Api\SymfBundle\Entity\Events', 'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($events);
        $em->flush();

        return new Response('', Response::HTTP_CREATED);
    }

     /**
     * @Route("api/events", name="events_list", methods={"GET"})
     * 
     */
    public function listAction()
    {

        $events = $this->getDoctrine()->getRepository('ApiSymfBundle:Events')->findAll();

        $data = $this->get('jms_serializer')->serialize($events, 'json');

        $response = new Response($data);

        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
    * @Route("api/dashboard", name="events_dashboard")
    * @Method({"GET"})
    */
    public function dashboardAction()
    {

    }
}
