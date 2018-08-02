<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;

class ProfileController extends Controller
{
    /**
     * @Route("/profile/{user}", name="profile")
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction(User $user = null)
    {
        if ($user === null) {
            $user = $this->getUser();
        }

        return $this->render('@App/Profile/index.html.twig', array(
            'user' => $user
        ));
    }

    /**
     * @Route("/profile/edit/{user_id}", name="editProfile", defaults={"user"=null})
     */
    public function editAction($user_id = null)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $currentUser = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();

        if ($user_id === null) {
            $user = $currentUser;
        } else {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');

            $user = $entityManager->getRepository(User::class)
        }

        return $this->render('@App/Profile/index.html.twig', array(
            'user' => $user
        ));
    }

}
