<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

use AppBundle\Entity\Chick;

/**
 * User
 *
 * @ORM\Table(name="app_users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="Email already token")
 * @UniqueEntity(fields="username", message="Username already token")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=25, unique=true)
     * @Assert\Length(min=2)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @var
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=64)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=254, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var bool
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_confirmed", type="boolean")
     */
    private $isConfirmed;

    /**
     * @var
     * @ORM\Column(name="confirmation_token", type="string", length=254, nullable=true)
     */
    private $confirmationToken;

    /**
     * @var
     * @ORM\Column(name="reset_password_token", type="string", length=254, nullable=true)
     */
    private $resetPasswordToken;

    /**
     * @var
     * @ORM\Column(name="reset_password_due_date", type="datetime", nullable=true)
     */
    private $resetPasswordDueDate;

    /**
     * @var
     *
     * @ORM\Column(type="array")
     */
    private $roles;


    /**
     * @var
     *
     * @ORM\OneToMany(targetEntity="Chick", mappedBy="owner")
     */
    private $chicks;

    /**
     * User constructor.
     */
    public function __construct() {
        $this->isConfirmed = false;
        $this->isActive = true;
        $this->roles = array('ROLE_USER');
    }

    public function getSalt()
    {
        return false;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function serialize()
    {
        return serialize( array(
            $this->id,
            $this->username,
            $this->password
        ) );
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password
        ) = unserialize($serialized, array('allowed_classes' => false));
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param $password
     */
    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @return bool
     */
    public function isConfirmed()
    {
        return $this->isConfirmed;
    }

    /**
     * @return array
     */
    public function setIsConfirmed($isConfirmed)
    {
        $this->isConfirmed = (bool) $isConfirmed;

        return $this;
    }

    /**
     * @return string
     */
    public function getConfiramtionToken()
    {
        return $this->confirmationToken;
    }

    /**
     * @param $token
     * @return $this
     */
    public function setConfirationToken($token)
    {
        $this->confirmationToken = $token;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getResetPasswordToken()
    {
        return $this->resetPasswordToken;
    }

    /**
     * @return mixed
     */
    public function getResetPasswordDueDate()
    {
        return $this->resetPasswordDueDate;
    }

    /**
     * @param \DateTime $dateTime
     * @return $this
     */
    public function setResetPasswordDueDate(\DateTime $dateTime)
    {
        $this->resetPasswordDueDate = $dateTime;

        return $this;
    }

    /**
     * @param $token
     * @return $this
     */
    public function setResetPasswordToken($token) {
        $this->resetPasswordToken = $token;

        return $this;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return mixed
     */
    public function getChicks()
    {
        return $this->chicks;
    }

    /**
     * @param $chicks
     */
    public function setChicks($chicks)
    {
        $this->chicks = $chicks;
    }
}

