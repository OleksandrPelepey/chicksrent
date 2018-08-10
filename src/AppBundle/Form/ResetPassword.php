<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/4/2018
 * Time: 2:11 PM
 */

namespace AppBundle\Form;

use AppBundle\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use AppBundle\Validator\Constraint\UserExists;

class ResetPassword extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('user_identifier', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new UserExists()
                ],
                'label' => 'User name or email'
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Reset password'
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'reset_password_form';
    }
}