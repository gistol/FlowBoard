<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity()
 * @ORM\Table(name="users")
 * @UniqueEntity(fields="email", message="Email already taken")
 * @ORM\HasLifecycleCallbacks()
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min = 4,
     *     max = 255
     * )
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min = 2,
     *     max = 50
     * )
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min = 2,
     *     max = 50
     * )
     */
    private $lastName;

    /**
     * @ORM\Column(type="boolean", length=1)
     */
    private $isEnabled = 0;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserToken", mappedBy="user", cascade={"remove"}, orphanRemoval=true)
     */
    protected $tokens;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getisEnabled()
    {
        return $this->isEnabled;
    }

    /**
     * @param mixed $isEnabled
     */
    public function setIsEnabled($isEnabled): void
    {
        $this->isEnabled = $isEnabled;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getTokens()
    {
        return $this->tokens;
    }

    /**
     * @param mixed $tokens
     */
    public function setTokens($tokens): void
    {
        $this->tokens = $tokens;
    }



}
