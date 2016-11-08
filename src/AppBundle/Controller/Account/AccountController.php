<?php

namespace AppBundle\Controller\Account;

use AppBundle\Entity\Application;
use AppBundle\Entity\Sensor;
use AppBundle\Enum\SensorUpdateAction;
use AppBundle\Form\ApplicationType;
use AppBundle\Form\SensorType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends Controller
{
    /**
     * @Route("/login", name="account_login")
     * @Route("/")
     * @param Request $request
     * @return Response
     */
    public function loginAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect($this->generateUrl('account_dashboard_view'));
        }

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(':account:login.html.twig', [
                'lastUsername' => $lastUsername,
                'error' => $error,
            ]
        );
    }

    /**
     *
     * @Route("/account/dashboard", name="account_dashboard_view")
     * @Template(":account:dashboard.html.twig")
     * @param Request $request
     * @return array
     */
    public function accountDashboardAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $sensors = $em->getRepository(Sensor::class)->getSensorsBelongingTo($user);
        $applications = $em->getRepository(Application::class)->getApplicationsBelongingTo($user);
        return [
            'sensors' => $sensors,
            'applications' => $applications,
        ];
    }

    /**
     * @param Request $request
     * @Route("/account/dashboard/add-sensor", name="account_add_sensor")
     * @Template(":account/common:form_view.html.twig")
     * @return array
     */
    public function accountAddSensorAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $sensor = new Sensor();
        $user = $this->getUser();
        $builder = $this->get('form.factory')->createBuilder(SensorType::class, $sensor);
        $form = $builder->getForm();
        $status = $message = null;
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $sensor->setUser($user);
                $em->persist($sensor);
                $em->flush();
                $message = 'Sensor added successfully';
                $status = 'success';
            }
        }
        $parameters = [
            'form' => $form != null ? $form->createView() : null,
            'message' => $message,
            'status' => $status,
            'form_title' => 'Add sensor',
            'url' => $this->generateUrl('account_add_sensor'),
        ];

        return $parameters;
    }

    /**
     * @Route("/account/sensors", name="account_sensors_view")
     * @Template(":account/sensor:sensors.html.twig")
     * @param Request $request
     * @return array
     */
    public function listSensorsAction(Request $request)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $sensors = $em->getRepository(Sensor::class)->findBy([
            'user' => $user,
        ]);

        return[
            'sensors' => $sensors,
        ];
    }

    /**
     * @Route("/account/remove-sensor/{id}", name="account_remove_sensor")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function removeSensorAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $sensor = $em->getRepository(Sensor::class)->findOneBy([
            'id' => $id,
        ]);
        if ($sensor !== null) {
            if ($sensor->getApplication() !== null) {
                $em->remove($sensor);
                $em->flush();
            }
        }
        return $this->redirectToRoute('account_sensors_view');
    }


    /**
     * @Route("/account/add-application", name="account_add_application")
     * @Template(":account/common:form_view.html.twig")
     * @param Request $request
     * @return array
     */
    public function addApplicationAction(Request $request)
    {
        $user = $this->getUser();
        $application = new Application();
        $em = $this->getDoctrine()->getManager();
        $sm = $this->get('rt.sensor.manager');
        $sensors = $em->getRepository(Sensor::class)->getApplicableSensorsBelongingTo($user);
        $builder = $this->get('form.factory')->createBuilder(ApplicationType::class, $application, [
            'sensors' => $sensors,
        ]);
        $form = $builder->getForm();
        $status = $message = null;
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $sensors = $application->getSensors();
                $sm->updateSensors($sensors, $application, SensorUpdateAction::ACTION_ADD);
                $em->persist($application);
                $reply = $this->get('rt.communication.manager')->sendApplicationData($application);
                if ($reply->status != 0) {
                    $em->remove($application);
                    $message = "There was an error adding the application: " . $reply->message;
                    $status = 'error';
                } else {
                    $em->flush();
                    $message = 'Application added successfully';
                    $status = 'success';
                }

            }
        }

        $parameters = [
            'form' => $form != null ? $form->createView() : null,
            'message' => $message,
            'status' => $status,
            'form_title' => 'Add application',
            'url' => $this->generateUrl('account_add_application'),
        ];

        return $parameters;
    }

    /**
     * @Route("/account/applications", name="account_applications_view")
     * @Template(":account/application:applications.html.twig")
     * @param Request $request
     * @return array
     */
    public function listApplicationsAction(Request $request)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $applications = $em->getRepository(Application::class)->getApplicationsBelongingTo($user);
        return[
            'applications' => $applications,
        ];
    }

    /**
     * @Route("/account/remove-application/{id}", name="account_remove_application")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function removeApplicationAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $sm = $this->get('rt.sensor.manager');
        $application = $em->getRepository(Application::class)->findOneBy([
            'id' => $id,
        ]);
        if ($application !== null) {
            $sensors = $application->getSensors();
            $sm->updateSensors($sensors, $application, SensorUpdateAction::ACTION_REMOVE);
            $em->remove($application);
            $em->flush();
        }
        return $this->redirectToRoute('account_applications_view');
    }
}

