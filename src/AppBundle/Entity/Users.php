<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsersRepository")
 */
class Users implements UserInterface, \Serializable
{


    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_USER = 'ROLE_USER';
    const ROLE_SUPER_ADMIN = 'ROLE_SUPERADMIN';

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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;



    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255, nullable=true)
     */
    private $token;



    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;



    private $plainPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=100)
     */
    private $role;



    /**
     * @var datetime
     *
     * @ORM\Column(name="date_from", type="datetime", nullable=true)
     */
    private $dateFrom;


    /**
     * @var datetime
     *
     * @ORM\Column(name="date_to", type="datetime", nullable=true)
     */
    private $dateTo;



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
     * @return Users
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
     * Get name
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->name;
    }


    /**
     * erease crentials
     *
     * @return string
     */
    public function eraseCredentials()
    {
        return null;
    }


    /**
     * Set Password
     *
     * @param string $password
     *
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get Password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return Users
     */
    public function setSalt($salt)
    {

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return null;
    }


    /**
     * Set role
     *
     * @param string $role
     *
     * @return Users
     */
    public function getRoles()
    {
        return [$this->role];
    }


    /**
     * Set role
     *
     * @param string $role
     *
     * @return Users
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }


    /**
     * Set role
     *
     * @param string $role
     *
     * @return Users
     */
    public function setPlainPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->password;
    }

    public function serialize()
    {
        return serialize([$this->id, $this->name]);
    }

    public function unserialize($serialized)
    {
        list($this->id, $this->name) = unserialize($serialized);
    }
    
    /**
     * Get token.
     *
     * @return token.
     */
    public function getToken()
    {
        return $this->token;
    }
    
    /**
     * Set token.
     *
     * @param token the value to set.
     */
    public function setToken($token)
    {
        $this->token = $token;
    }
    
    /**
     * Get dateFrom.
     *
     * @return dateFrom.
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }
    
    /**
     * Set dateFrom.
     *
     * @param dateFrom the value to set.
     */
    public function setDateFrom($dateFrom)
    {
        $this->dateFrom = $dateFrom;
    }
    
    /**
     * Get dateTo.
     *
     * @return dateTo.
     */
    public function getDateTo()
    {
        return $this->dateTo;
    }
    
    /**
     * Set dateTo.
     *
     * @param dateTo the value to set.
     */
    public function setDateTo($dateTo)
    {
        $this->dateTo = $dateTo;
    }
}

