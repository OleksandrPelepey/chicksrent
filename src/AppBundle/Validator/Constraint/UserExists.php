<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/4/2018
 * Time: 2:48 PM
 */

namespace AppBundle\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

class UserExists extends Constraint
{
    public $message = 'User with "{{ string }}" username or email does not exist.';
}