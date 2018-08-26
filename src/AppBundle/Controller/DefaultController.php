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
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/test-email", name="testEmail")
     *
     * @param \Swift_Mailer $mailer
     * @return void
     */
    public function testEmail(\Swift_Mailer $mailer) {
        $message = new \Swift_Message('Test Email.');

        $message->setFrom('sasha.pelepey@gmail.com')
            ->setTo('oleksandr.pelepey@gmail.com')
            ->setBody(
                '<h2>Test email</h2>',
                'text/html'
            );

        $mailer->send( $message );

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}
