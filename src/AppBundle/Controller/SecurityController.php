<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
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
//        $passwordEncoder = $this->get('security.password_encoder');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('homepage');
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
     * @Route("/reset-password", name="resetPassword")
     */
    public function resetPasswordAction(Request $request)
    {
        return $this->render('@App/SecurityController/reset_password.html.twig', array(
            // ...
        ));
    }
}
