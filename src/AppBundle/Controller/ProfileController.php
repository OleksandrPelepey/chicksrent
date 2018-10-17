<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;

class ProfileController extends Controller
{
    /**
     * @Route("/profile/{user}", name="profile")
     */
    public function indexAction(User $user)
    {
        $currentUser = $this->getUser();
        
        if ($currentUser && $user->getId() === $currentUser->getId()) {
            return $this->redirectToRoute('myProfile');
        }
        
        return $this->getProfilePage($user);
    }

    /**
     * @Route("/profile", name="myProfile")
     * 
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function getMyProfileAction() 
    {
        return $this->getProfilePage( $this->getUser() );
    }

    /**
     * @Route("/profile/edit/{editedUser}", name="editProfile")
     * 
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function editAction(User $editedUser)
    {
        return $this->getEditUserPage($editedUser);
    }

    /**
     * @Route("/profile/edit", name="editCurrentProfile")
     * 
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function editCurrentAction() {
        $currentUser = $this->getUser();

        return $this->getEditUserPage($currentUser);
    }
    
    protected function getEditUserPage(User $editedUser) {
        $this->denyAccessUnlessGranted('edit', $editedUser);

        return $this->render('@App/Profile/index.html.twig', array(
            'user' => $editedUser
        ));
    }

    protected function getProfilePage(User $user) 
    {
        return $this->render('@App/Profile/index.html.twig', array(
            'user' => $user
        ));
    }

    protected function createNotFoundUserExpertion() 
    {
        return $this->createNotFoundException(
            sprintf('User was not found')
        );
    }
}
