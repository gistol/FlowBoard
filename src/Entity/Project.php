<?php
/**
 * Created by PhpStorm.
 * User: jeroenfrenken
 * Date: 21/11/2018
 * Time: 22:30
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 * @ORM\Table(name="project")
 */
class Project implements \JsonSerializable
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=4, name="project_key")
     */
    private $key;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProjectUsers", mappedBy="project")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Organisation", inversedBy="projects")
     * @ORM\JoinColumn(name="org_id", referencedColumnName="id")
     */
    private $organisation;

    /**
     * @Assert\NotBlank(
     *     message="Name can not be blank"
     * )
     * @Assert\Length(
     *     min = 2,
     *     max = 25,
     *     minMessage = "Project name must be at least {{ limit }} characters long",
     *     maxMessage = "Project name cannot be longer than {{ limit }} characters"
     * )
     * @Assert\Regex(
     *     pattern="/^[_A-z0-9]*((-)*[_A-z0-9])*$/",
     *     match=true,
     *     message="Project name can not contain spaces or special characters"
     * )
     * @ORM\Column(type="string", length=25)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Columns", mappedBy="project", cascade={"remove"})
     */
    private $columns;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Issue", mappedBy="project")
     */
    private $issues;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

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
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     */
    public function setKey($key): void
    {
        $this->key = $key;
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
    public function getOrganisation()
    {
        return $this->organisation;
    }

    /**
     * @param mixed $organisation
     */
    public function setOrganisation($organisation): void
    {
        $this->organisation = $organisation;
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

    private function orderSort($a,$b) {
        return $a->getOrder() > $b->getOrder();
    }

    /**
     * @return mixed
     */
    public function getColumns()
    {
        $res = [];

        if ($this->columns === null) $this->columns = [];

        foreach ($this->columns as $column) $res[] = $column;

        usort($res, array($this, "orderSort"));

        return $res;
    }

    /**
     * @param mixed $columns
     */
    public function setColumns($columns): void
    {
        $this->columns = $columns;
    }

    /**
     * @return mixed
     */
    public function getIssues()
    {
        return $this->issues;
    }

    /**
     * @param mixed $issues
     */
    public function setIssues($issues): void
    {
        $this->issues = $issues;
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
            '_id' => $this->getName(),
            'key' => $this->getKey(),
            'org' => $this->getOrganisation()->getName(),
            'name' => $this->getName(),
            'columns' => $this->getColumns(),
            'created' => $this->getCreated(),
        ];
    }


}