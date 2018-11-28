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
 * @ORM\Table(name="columns")
 */
class Columns implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", length=2)
     */
    private $order;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ColumnStatus", inversedBy="column")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="columns")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    private $project;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Issue", mappedBy="column")
     */
    private $issues;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $order
     */
    public function setOrder($order): void
    {
        $this->order = $order;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param mixed $project
     */
    public function setProject($project): void
    {
        $this->project = $project;
    }

    /**
     * @return mixed
     */
    public function getIssues()
    {
        $res = [];

        foreach ($this->issues as $issue) $res[] = $issue;

        return $res;
    }

    /**
     * @param mixed $issues
     */
    public function setIssues($issues): void
    {
        $this->issues = $issues;
    }

    public function jsonSerialize()
    {
        return [
            '_id' => $this->getId(),
            'order' => $this->getOrder(),
            'status' => $this->getStatus(),
            'issues' => $this->getIssues()
        ];
    }


}