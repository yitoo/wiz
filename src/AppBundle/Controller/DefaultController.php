<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/praticien", name="practitioner")
     */
    public function practitionerAction()
    {
        return $this->render('default/practitioner.twig');
    }

    /**
     * @Route("/practitioner-signup", name="practitioner_signup", requirements={"method":"post'"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function practitionerSignUpAction(Request $request)
    {
        if (!$request->request->get('email') || !$request->request->get('fullName')) {
            return $this->redirectToRoute('practitioner');
        }

        return $this->doSignUp('practitioner', $request);
    }

    /**
     * @Route("/entreprise", name="company")
     */
    public function companyAction()
    {
        return $this->render('default/company.twig');
    }

    /**
     * @Route("/company-signup", name="company_signup", requirements={"method":"post'"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function companySignUpAction(Request $request)
    {
        if (!$request->request->get('email') || !$request->request->get('company')) {
            return $this->redirectToRoute('company');
        }

        return $this->doSignUp('company', $request);
    }

    /**
     * @Route("/votre-inscription", name="signup_success")
     */
    public function signUpSuccessAction()
    {
        if (!$this->container->get('session')->getFlashBag()->has('signup_success')) {
            return $this->redirectToRoute('homepage');
        }

        return $this->render('default/signup_success.twig');
    }

    /**
     * @Route("/mentions-legales", name="legal_mentions")
     */
    public function legalMentionsAction()
    {
        return $this->render('default/legal_mentions.twig');
    }

    private function doSignUp($profile, Request $request)
    {
        if ($profile == 'company') {
            $profileName = $request->request->get('company');
            $view = ':emails:company_signup.html.twig';
        } else {
            $profileName = $request->request->get('fullName');
            $view = ':emails:practitioner_signup.html.twig';
        }

        $email = $request->request->get('email');
        $message = (new \Swift_Message('WorkInZen'))
            ->setFrom('virginie@workinzen.fr', 'Virginie Plé')
            ->setTo($email)
            ->setBody(
                $this->renderView(
                    $view,
                    array('name' => $profileName)
                ),
                'text/html'
            )
        ;
        $this->get('mailer')->send($message);

        $this->addFlash('signup_success', "Merci $profileName, nous vous avons envoyé un email à l'adresse $email");

        return $this->redirectToRoute('signup_success');
    }
}