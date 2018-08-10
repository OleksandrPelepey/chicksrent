<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Form\ResetPassword;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class SecurityController extends Controller
{
    /**
     * @Route("/register", name="register")
     *
     */
    public function registerUserAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('@App/SecurityController/register_user.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/login", name="login")
     */
    public function loginUserAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUserName = $authenticationUtils->getLastUsername();

        return $this->render('@App/SecurityController/login_user.html.twig', array(
            'last_username' => $lastUserName,
            'error' => $error
        ));
    }

    /**
     * @Route("/approve-email/send", name="sendApproveEmailKey")
     */
    public function sendApproveEmailKeyAction($approveKey)
    {
        return $this->render('@App/SecurityController/reset_password.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/approve-email/{approveKey}", name="approveEmail")
     */
    public function approveEmailAction($approveKey)
    {
        return $this->render('@App/SecurityController/reset_password.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/reset-password", name="resetPassword")
     */
    public function resetPasswordAction(Request $request)
    {
        $form = $this->createForm(ResetPassword::class);

        $form->handleRequest($request);

        return $this->render('@App/SecurityController/reset_password.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
