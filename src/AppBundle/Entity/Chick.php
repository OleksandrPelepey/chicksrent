<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\User;

/**
 * Chicken
 *
 * @ORM\Table(name="chicken")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ChickenRepository")
 */
class Chick
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
     * @ORM\Column(name="name", type="string", nullable=false, length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="birthday", type="string", nullable=false, length=255)
     */
    private $birthday;

    /**
     * @var int
     *
     * @ORM\Column(name="hour_rate", nullable=false, type="integer")
     */
    private $hourRate;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="chicks")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    private $owner;


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
     * Set name
     *
     * @param string $name
     *
     * @return Chicken
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set birthday
     *
     * @param string $birthday
     *
     * @return Chicken
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return string
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set hourRate
     *
     * @param integer $hourRate
     *
     * @return Chicken
     */
    public function setHourRate($hourRate)
    {
        $this->hourRate = $hourRate;

        return $this;
    }

    /**
     * Get hourRate
     *
     * @return int
     */
    public function getHourRate()
    {
        return $this->hourRate;
    }

    public function getOwner() {
        return $this->owner;
    }

    public function setOwner(User $owner) {
        $this->owner = $owner;
    }
}

