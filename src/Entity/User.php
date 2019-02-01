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
class User implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min = 4,
     *     max = 255
     * )
     * @Assert\Email()
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min = 2,
     *     max = 50
     * )
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min = 2,
     *     max = 50
     * )
     */
    protected $lastName;

    /**
     * @ORM\Column(type="boolean", length=1)
     */
    protected $isEnabled = 0;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserToken", mappedBy="user", cascade={"remove"}, orphanRemoval=true)
     */
    protected $tokens;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrganisationUsers", mappedBy="users")
     */
    protected $organisations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProjectUsers", mappedBy="users")
     */
    protected $projects;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Issue", mappedBy="assigned")
     */
    protected $assigndIssues;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Issue", mappedBy="reporter")
     */
    protected $reportedIssues;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserInvitations", mappedBy="user", cascade={"remove"})
     */
    private $invitations;

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

    /**
     * @return mixed
     */
    public function getOrganisations()
    {
        return $this->organisations;
    }

    /**
     * @param mixed $organisations
     */
    public function setOrganisations($organisations): void
    {
        $this->organisations = $organisations;
    }

    /**
     * @return mixed
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * @param mixed $projects
     */
    public function setProjects($projects): void
    {
        $this->projects = $projects;
    }

    /**
     * @return mixed
     */
    public function getAssigndIssues()
    {
        return $this->assigndIssues;
    }

    /**
     * @param mixed $assigndIssues
     */
    public function setAssigndIssues($assigndIssues): void
    {
        $this->assigndIssues = $assigndIssues;
    }

    /**
     * @return mixed
     */
    public function getReportedIssues()
    {
        return $this->reportedIssues;
    }

    /**
     * @return mixed
     */
    public function getInvitations()
    {
        return $this->invitations;
    }

    /**
     * @param mixed $invitations
     */
    public function setInvitations($invitations): void
    {
        $this->invitations = $invitations;
    }

    /**
     * @param mixed $reportedIssues
     */
    public function setReportedIssues($reportedIssues): void
    {
        $this->reportedIssues = $reportedIssues;
    }

    public function jsonSerialize()
    {
        return [
            '_id' => $this->getId(),
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName(),
            'email' => $this->getEmail()
        ];
    }


}
