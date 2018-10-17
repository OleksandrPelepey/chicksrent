<?php

namespace AppBundle\Security;

use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

/**
 * Description of UserVoter
 *
 * @author Oleksandr
 */
class UserVoter extends Voter {
    const EDIT = 'edit';
    
    private $decisionMaker;

    public function __construct(AccessDecisionManagerInterface $decisionMaker) {
        $this->decisionMaker = $decisionMaker;
    }

    protected function supports($attribute, $subject) {
        if ( !in_array($attribute, [self::EDIT]) ) {
            return false;
        }
        
        if ( !$subject instanceof User ) {
            return false;
        }

        return true;
    }
    
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token) {
        $currentUser = $token->getUser();

        if ( !$currentUser ) {
            return false;
        }
        
        if ( $this->decisionMaker->decide($token, ['ROLE_ADMIN']) ) {
            return true;
        }
        
        $editedUser = $subject;
        
        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($editedUser, $currentUser);
        }
        
        throw new \LogicException('Had not be reached');
    }
    
    private function canEdit(User $editedUser, User $editor) {
        return $editedUser->getId() === $editor->getId();
    }
}
