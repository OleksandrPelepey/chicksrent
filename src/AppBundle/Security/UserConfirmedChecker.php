<?php

namespace AppBundle\Security;

use AppBundle\Entity\User as AppUser;
use AppBundle\Security\Exception\NotConfirmedEmailException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserConfirmedChecker implements UserCheckerInterface {
    public function checkPreAuth(UserInterface $user) {
        if (!$user instanceof AppUser) {
            return;
        }

        if (!$user->isConfirmed()) {
            throw new NotConfirmedEmailException('Your email is not confirmed.');
        }
    }

    public function checkPostAuth(UserInterface $user) {
        return;
    }
}
