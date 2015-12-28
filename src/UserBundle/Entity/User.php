<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=23, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=23, nullable=true)
     */
    private $lastName;

    /**
     * @var int
     *
     * @ORM\Column(name="age", type="integer", nullable=true)
     */
    private $age;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=40, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="dect", type="string", length=5, nullable=true)
     */
    private $dect;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=40, nullable=true)
     */
    private $mobile;

    /**
     * @var string
     *
     * @ORM\Column(name="jabber", type="string", length=40, nullable=true)
     */
    private $jabber;

    /**
     * @var bool
     *
     * @ORM\Column(name="checkedIn", type="boolean")
     */
    private $checkedIn;

    public function __construct()
    {
        parent::__construct();
        $this
            ->setCheckedIn(false)
        ;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return User
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set dect
     *
     * @param string $dect
     *
     * @return User
     */
    public function setDect($dect)
    {
        $this->dect = $dect;

        return $this;
    }

    /**
     * Get dect
     *
     * @return string
     */
    public function getDect()
    {
        return $this->dect;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     *
     * @return User
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set jabber
     *
     * @param string $jabber
     *
     * @return User
     */
    public function setJabber($jabber)
    {
        $this->jabber = $jabber;

        return $this;
    }

    /**
     * Get jabber
     *
     * @return string
     */
    public function getJabber()
    {
        return $this->jabber;
    }

    /**
     * Set checkedIn
     *
     * @param boolean $checkedIn
     *
     * @return User
     */
    public function setCheckedIn($checkedIn)
    {
        $this->checkedIn = $checkedIn;

        return $this;
    }

    /**
     * Get checkedIn
     *
     * @return bool
     */
    public function getCheckedIn()
    {
        return $this->checkedIn;
    }
}

