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
     * @Route("/signup", name="signup", requirements={"method":"post'"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function signUpAction(Request $request)
    {
        $fullName = $request->request->get('fullName');
        $email = $request->request->get('email');
        $message = (new \Swift_Message('WorkInZen'))
            ->setFrom('virginie@workinzen.fr', 'Virginie Plé')
            ->setTo($email)
            ->setBody(
                $this->renderView(
                    ':emails:signup.html.twig',
                    array('name' => $fullName)
                ),
                'text/html'
            )
        ;
        $this->get('mailer')->send($message);

        $this->addFlash('info', "Merci $fullName, nous vous avons envoyé un email à l'adresse $email");

        return $this->redirectToRoute('homepage');
    }
}