<?php

namespace AppBundle\Controller\Common;

use AppBundle\Form\RegistrationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="register")
     * @Template(":public:register.html.twig")
     */
    public function registerAction(Request $request)
    {
        $userManager = $this->get('rt.user.manager');
        $entityManager = $this->getDoctrine()->getManager();
        $user = $userManager->createUser();
        $builder = $this->get('form.factory')->createBuilder(RegistrationType::class, $user);
        $form = $builder->getForm();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $userManager->updatePassword($user);
                $entityManager->persist($user);
                $entityManager->flush();
                $this->get('rt.aws.manager')->launchNewInstance('Dummy', $user);

                return $this->redirectToRoute('registration_submitted');
            }
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/registration-submitted", name="registration_submitted")
     * @Template(":public:registration_submitted.html.twig")
     * @param Request $request
     */
    public function registrationSubmittedAction(Request $request)
    {
        return [];
    }

}
