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
 * @ORM\Table(name="issue_type")
 */
class IssueType implements \JsonSerializable
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Issue", mappedBy="status")
     */
    private $issues;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean", length=1)
     */
    private $containsSub;

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
    public function getContainsSub()
    {
        return $this->containsSub;
    }

    /**
     * @param mixed $containsSub
     */
    public function setContainsSub($containsSub): void
    {
        $this->containsSub = $containsSub;
    }

    public function jsonSerialize()
    {
        return [
            '_id' => $this->getName(),
            'name' => $this->getName(),
            'contains_sub' => $this->getContainsSub()
        ];
    }


}