<?php
/**
 * Created by PhpStorm.
 * User: jeroenfrenken
 * Date: 21/11/2018
 * Time: 22:29
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="organisation")
 */
class Organisation implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(
     *     message="Organisation name can not be blank"
     * )
     * @Assert\Length(
     *     min = 2,
     *     max = 25,
     *     minMessage = "Organisation name must be at least {{ limit }} characters long",
     *     maxMessage = "Organisation name cannot be longer than {{ limit }} characters"
     * )
     * @Assert\Regex(
     *     pattern="/^[_A-z0-9]*((-)*[_A-z0-9])*$/",
     *     match=true,
     *     message="Organisation name can not contain spaces or special characters"
     * )
     * @ORM\Column(type="string", length=25)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $whitelabelJoin;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrganisationUsers", mappedBy="organisation")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserInvitations", mappedBy="org", cascade={"remove"})
     */
    private $invitations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Project", mappedBy="organisation", cascade={"remove"})
     */
    private $projects;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * Organisation constructor
     */
    public function __construct()
    {
        $this->setCreated(new \DateTime('now'));
    }

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getWhitelabelJoin()
    {
        return $this->whitelabelJoin;
    }

    /**
     * @param mixed $whitelabelJoin
     */
    public function setWhitelabelJoin($whitelabelJoin): void
    {
        $this->whitelabelJoin = $whitelabelJoin;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        if ($this->users === null) return [];

        $out = [];

        foreach ($this->users as $value) {
            $out[] = [
                    'user' => $value->getUser(),
                    'access' => $value->getAccess()
                ];
        }

        return $out;
    }

    /**
     * @param mixed $users
     */
    public function setUsers($users): void
    {
        $this->users = $users;
    }

    /**
     * @return mixed
     */
    public function getProjects()
    {
        if ($this->projects === null) return [];
        $out = [];

        foreach ($this->projects as $project) $out[] = $project;

        return $out;
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
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created): void
    {
        $this->created = $created;
    }

    public function jsonSerialize()
    {
        return [
            'name' => $this->getName(),
            'user_count' => count($this->getUsers()),
            'users' => $this->getUsers(),
            'projects' => $this->getProjects()
        ];
    }


}