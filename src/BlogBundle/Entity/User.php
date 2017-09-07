<?php

namespace BlogBundle\Entity;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * User
 */
class User implements UserInterface
{
    /**
     * @var integer
     */
    private $id;
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $surname;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    private $plainPassword;

    private $roles;
    /**
     * @var string
     */
    private $imagen;

    /**
     * @var date
     */
    private $birthday;	
	
	public function __construct() {
        $this->entry = new \Doctrine\Common\Collections\ArrayCollection();
        $this->roles = array();
    }

    public function __toString() {
        return $this->name;
    }
	// AUTH
	
	public function getUsername() {
		return $this->email;
	}
	
	public function getSalt() {
		return null;
	}

	public function eraseCredentials() {
		
	}

	// END AUTH
	
	
    /**
     * Get id
     *
     * @return integer
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
     * @return User
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
     * Set surname
     *
     * @param string $surname
     *
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
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
     * Set imagen
     *
     * @param string $imagen
     *
     * @return User
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Get imagen
     *
     * @return string
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set date
     *
     * @param birthday $birthday
     *
     * @return Entry
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return birthday
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

}

