<?php

namespace AppBundle\Controller\Account;

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
}
