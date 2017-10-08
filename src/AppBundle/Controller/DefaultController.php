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
        $fullName = $request->request->get('fullName');
        $email = $request->request->get('email');
        $message = (new \Swift_Message('WorkInZen'))
            ->setFrom('virginie@workinzen.fr', 'Virginie Plé')
            ->setTo($email)
            ->setBody(
                $this->renderView(
                    ':emails:practitioner_signup.html.twig',
                    array('name' => $fullName)
                ),
                'text/html'
            )
        ;
        $this->get('mailer')->send($message);

        $this->addFlash('info', "Merci $fullName, nous vous avons envoyé un email à l'adresse $email");

        return $this->redirectToRoute('signup_success');
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
        $fullName = $request->request->get('company');
        $email = $request->request->get('email');
        $message = (new \Swift_Message('WorkInZen'))
            ->setFrom('virginie@workinzen.fr', 'Virginie Plé')
            ->setTo($email)
            ->setBody(
                $this->renderView(
                    ':emails:company_signup.html.twig',
                    array('name' => $fullName)
                ),
                'text/html'
            )
        ;
        $this->get('mailer')->send($message);

        $this->addFlash('info', "Merci $fullName, nous vous avons envoyé un email à l'adresse $email");

        return $this->redirectToRoute('signup_success');
    }

    /**
     * @Route("/votre-inscription", name="signup_success")
     */
    public function signUpSuccessAction()
    {
        return $this->render('default/signup_success.twig');
    }
}