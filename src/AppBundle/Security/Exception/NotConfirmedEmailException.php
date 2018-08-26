<?php 

namespace AppBundle\Security\Exception;

use Symfony\Component\Security\Core\Exception\AccountStatusException;

class NotConfirmedEmailException extends AccountStatusException {

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getMessageKey() {
        return 'You have confirm your email address. Check your mailbox.';
    }
}
