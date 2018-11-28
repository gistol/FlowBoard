<?php
/**
 * Created by PhpStorm.
 * User: jeroenfrenken
 * Date: 21/11/2018
 * Time: 22:30
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
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
     * @ORM\OneToMany(targetEntity="ProjectUsers", mappedBy="project")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Organisation", inversedBy="projects")
     * @ORM\JoinColumn(name="org_id", referencedColumnName="id")
     */
    private $organisation;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Columns", mappedBy="project")
     */
    private $columns;

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

        foreach ($this->columns as $column) {
            $res[] = $column;
        }



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
            'org' => $this->getOrganisation()->getName(),
            'name' => $this->getName(),
            'columns' => $this->getColumns(),
            'created' => $this->getCreated(),
        ];
    }


}