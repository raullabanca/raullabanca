<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Person;
use AppBundle\Entity\ShipOrder;
use AppBundle\Entity\UploadObject;
use AppBundle\Service\SerializerHandler;

use Symfony\Component\Serializer\Encoder\XmlEncoder;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
    
    /**
     * @Route("/upload", name="uploadFile")
     * @Method({"POST"})
     */
    public function uploadAction(Request $request) {

        try {

            $myFiles = $request->files->get('files');
            $data = file_get_contents($myFiles[0]);

            $serializer = SerializerHandler::getSerializer();
            $uploadObject = $serializer->deserialize($data, UploadObject::class, 'xml');    

            $persons = $uploadObject->getPerson();
            if ($persons != null) {

                foreach ($persons as $person ) {

                    $persistablePerson = SerializerHandler::unserialzeArray(Person::class, $person);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($persistablePerson);
                    $em->flush();
                }
            }

            $shiporders = $uploadObject->getShipOrder();
            if ($shiporders != null) {

                foreach ($shiporders as $shiporder ) {

                    $persistableShipOrder = SerializerHandler::unserialzeArray(ShipOrder::class, $shiporder);
                    $repository = $this->getDoctrine()->getRepository('AppBundle:Person');
                    $orderpersonEntity = $repository->find($persistableShipOrder->getOrderPerson());
                    $persistableShipOrder->setOrderPerson($orderpersonEntity);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($persistableShipOrder);
                    $em->flush();
                }
            }

            return new JsonResponse(array('message' => "Data imported successfully."));
        } 
        catch (\Exception $e) {
            return new JsonResponse(array('error' => $e->getMessage()));
        }
    }

    /**
     * @Route("/api/people", name="getPeople")
     * @Method({"GET"})
     */
    public function peopleAction() {

        $repository = $this->getDoctrine()->getRepository('AppBundle:Person');
        $persons = $repository->findAll();
        $serializer = SerializerHandler::getSerializer();
        $jsonResponse = $serializer->serialize($persons, 'json');
        return new JsonResponse(json_decode($jsonResponse));
    }

    /**
     * @Route("/api/person/{id}", name="getPerson")
     * @Method({"GET"})
     */
    public function personAction($id) {

        $repository = $this->getDoctrine()->getRepository('AppBundle:Person');
        $persons = $repository->find($id);
        $serializer = SerializerHandler::getSerializer();
        $jsonResponse = $serializer->serialize($persons, 'json');
        return new JsonResponse(json_decode($jsonResponse));
    }

    /**
     * @Route("/api/shiporders", name="getShipOrders")
     * @Method({"GET"})
     */
    public function shipOrdersAction() {

        $repository = $this->getDoctrine()->getRepository('AppBundle:ShipOrder');
        $shiporders = $repository->findAll();
        $serializer = SerializerHandler::getSerializer();
        $jsonResponse = $serializer->serialize($shiporders, 'json');
        return new JsonResponse(json_decode($jsonResponse));
    }

    /**
     * @Route("/api/shiporder/{id}", name="getShipOrder")
     * @Method({"GET"})
     */
    public function shipOrderAction($id) {

        $repository = $this->getDoctrine()->getRepository('AppBundle:ShipOrder');
        $shiporder = $repository->find($id);
        $serializer = SerializerHandler::getSerializer();
        $jsonResponse = $serializer->serialize($shiporder, 'json');
        return new JsonResponse(json_decode($jsonResponse));
    }
}
