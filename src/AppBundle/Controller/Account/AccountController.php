<?php

namespace AppBundle\Controller\Account;

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
        return [];
    }
}
