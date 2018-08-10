<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/4/2018
 * Time: 2:51 PM
 */

namespace AppBundle\Validator\Constraint;

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

use AppBundle\Entity\User;

class UserExistsValidator extends ConstraintValidator
{
    private $container;

    public function validate($value, Constraint $constraint) {
        if (null === $value || '' === $value) {
            return;
        }

        $entityManager = $this->getDoctrine();

        $user = $entityManager
            ->getRepository(User::class)
            ->loadUserByUsername($value);

        if ($user === null) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }

    public function __construct(ContainerInterface $container, LoggerInterface $logger)
    {
        $logger->info(self::class . ' instnce was created.');

        $this->container = $container;
    }

    protected function getDoctrine() {
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not registered in your application. Try running "composer require symfony/orm-pack".');
        }

        return $this->container->get('doctrine');
    }
}