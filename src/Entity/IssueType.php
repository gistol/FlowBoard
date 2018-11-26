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
class IssueType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

}