<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ChickController extends Controller
{
    /**
     * @Route("/chicks")
     */
    public function viewAllAction()
    {
        return $this->render('AppBundle:Chick:chicks.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/chick/{id}")
     */
    public function viewChickAction($id)
    {
        return $this->render('AppBundle:Chick:chick.html.twig', array(
            // ...
        ));
    }

}
