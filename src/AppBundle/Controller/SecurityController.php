<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Form\ResetPassword;
use AppBundle\Utils\TokensGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class SecurityController extends Controller
{
    /**
     * @Route("/register", name="register")
     *
     */
    public function registerUserAction(
        Request $request,
        TokensGenerator $tokenGenerator,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $user->setConfirationToken( $tokenGenerator->generateToken() );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->sendAccountConfirmationMail($user);
            
            $this->container->get('session')->getFlashBag()->add('success', '
                Check your email addres for confirmation letter.
            ');

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
     * @Route("/confirm-email/{approveKey}", name="approveEmail")
     */
    public function approveEmailAction($approveKey)
    {
        $entityManger = $this->getDoctrine();

        $user = $entityManger
            ->getRepository(User::class)
            ->findOneBy([
                'confirmationToken' => $approveKey
            ]);

        if ($user) {
            $user->setIsConfirmed(true);
            $user->setConfirationToken(null);
            $entityManger->getManager()->flush();

            return $this->render('@App/SecurityController/confirmed_email.html.twig');
        }

        throw $this->createNotFoundException('Such key does not exist.');
    }

    /**
     * @Route("/reset-password/{resetPasswordToken}", name="resetPassword")
     */
    public function resetPasswordAction(Request $request, $resetPasswordToken)
    {
    }

    /**
     * @Route("/reset-password", name="resetPasswordForm")
     */
    public function resetPasswordFormAction(Request $request, $resetPasswordToken = null)
    {
        $form = $this->createForm(ResetPassword::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->loadUserByUsername( $form->getData()['user_identifier'] );

            $this->sendResetPasswordEmail($user);

            return $this->render('@App/SecurityController/reset_password_send.html.twig');
        }

        return $this->render('@App/SecurityController/reset_password.html.twig', array(
            'form' => $form->createView()
        ));
    }

    protected function sendResetPasswordEmail(User $user)
    {
        $mailer = $this->container->get('swiftmailer.mailer.default');

        $message = ( new \Swift_Message('Reset password.') )
            ->setTo( $user->getEmail() )
            ->setSender( $this->container->getParameter('swiftmailer.sender_address') )
            ->setBody(
                $this->renderView('Emails/reset-password.html.twig', [
                    'reset_password_link' => $this->generateUrl('resetPassword', [
                        'resetPasswordToken' => $user->getResetPasswordToken()
                    ], UrlGeneratorInterface::ABSOLUTE_URL)
                ]),
                'text/html'
            );

        $res = $mailer->send($message);

        return $res;
    }

    protected function sendAccountConfirmationMail(User $user)
    {
        $mailer = $this->container->get('swiftmailer.mailer.default');

        $message = ( new \Swift_Message('Account email confirmation.') )
            ->setTo( $user->getEmail() )
            ->setSender( $this->container->getParameter('swiftmailer.sender_address') )
            ->setBody(
                $this->renderView('Emails/confirm-email.html.twig', [
                    'confiramtion_link' => $this->generateUrl('approveEmail', [
                        'approveKey' => $user->getConfiramtionToken()
                    ], UrlGeneratorInterface::ABSOLUTE_URL)
                ]),
                'text/html'
            );

        $res = $mailer->send($message);

        return $res;
    }
}
