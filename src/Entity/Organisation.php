<?php
/**
 * Created by PhpStorm.
 * User: jeroenfrenken
 * Date: 21/11/2018
 * Time: 22:29
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="organisation")
 */
class Organisation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $whitelabelJoin;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrganisationUsers", mappedBy="id")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Project", mappedBy="id")
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
        return $this->users;
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

}