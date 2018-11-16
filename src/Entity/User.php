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

}
