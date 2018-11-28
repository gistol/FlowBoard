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
 * @ORM\Table(name="column_status")
 */
class ColumnStatus implements \JsonSerializable
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
     * @ORM\OneToMany(targetEntity="App\Entity\Columns", mappedBy="status")
     */
    private $column;

    /**
     * @ORM\Column(type="boolean", length=1)
     */
    private $isDone;

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
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * @param mixed $column
     */
    public function setColumn($column): void
    {
        $this->column = $column;
    }

    /**
     * @return mixed
     */
    public function getisDone()
    {
        return $this->isDone;
    }

    /**
     * @param mixed $isDone
     */
    public function setIsDone($isDone): void
    {
        $this->isDone = $isDone;
    }

    public function jsonSerialize()
    {
        return [
            '_id' => $this->getId(),
            'name' => $this->getName(),
            'is_done' => $this->getisDone()
        ];
    }


}