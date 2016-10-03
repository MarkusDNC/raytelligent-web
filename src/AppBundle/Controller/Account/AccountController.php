<?php

namespace AppBundle\Controller\Account;

use AppBundle\Entity\Sensor;
use AppBundle\Form\SensorType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AccountController extends Controller
{
    /**
     * @Route("/login", name="account_login")
     * @Template(":account:login.html.twig")
     * @param Request $request
     * @return array
     */
    public function loginAction(Request $request)
    {
        return [];
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
        return [];
    }

    /**
     * @param Request $request
     * @Route("/account/dashboard/add-sensor", name="account_add_sensor")
     * @Template(":account/sensor:new_sensor.html.twig")
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
}

