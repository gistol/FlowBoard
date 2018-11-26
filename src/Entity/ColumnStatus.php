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
class ColumnStatus
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
     * @ORM\Column(type="boolean", length=1)
     */
    private $isInProgress;

    /**
     * @ORM\Column(type="boolean", length=1)
     */
    private $isIdle;

}