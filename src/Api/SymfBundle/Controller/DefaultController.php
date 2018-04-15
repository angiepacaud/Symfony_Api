<?php

namespace Api\SymfBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Api\SymfBundle\Entity\Events;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


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
     * @Rest\Post(path = "/api/events")
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("events", converter="fos_rest.request_body")
     */
    public function createAction(Events $events)
    {
        $data = $this->get('jms_serializer')->deserialize($request->getContent(), 'array', 'json');
        $events = new Events;
        $form = $this->get('form.factory')->create(EventsType::class, $events);
        $form->submit($data);
        $em = $this->getDoctrine()->getManager();
        $em->persist($events);
        $em->flush();

        return $this->view($events, Response::HTTP_CREATED, ['Location' => $this->generateUrl('events_list', ['id' => $events->getId(), UrlGeneratorInterface::ABSOLUTE_URL])]);

        // $data = $request->getContent();
        // $events = $this->get('jms_serializer')->deserialize($data, 'Api\SymfBundle\Entity\Events', 'json');
        // $em = $this->getDoctrine()->getManager();
        // $em->persist($events);
        // $em->flush();

        // return new Response('', Response::HTTP_CREATED);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name')

            ->add('referrer')

            ->add('createdad');

    }


    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(array(

            'data_class' => 'Api\SymfBundle\Entity\Events'

        ));

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
    * @Route("api/dashboard", name="events_dashboard", methods={"GET"})
    * 
    */
    public function dashboardAction()
    {
        //$events = $this->getDoctrine()->getRepository('ApiSymfBundle:Events')->findAll();

        //$data = $this->get('jms_serializer')->serialize($events, 'json');

       // $response = new Response($data);

        //$response->headers->set('Content-Type', 'application/json');

         //return $response;
return $this->createQueryBuilder('a')
 ->select('COUNT(a)')
 ->getQuery()
 ->getSingleScalarResult();
    }
}
