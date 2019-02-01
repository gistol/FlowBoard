<?php
/**
 * Created by PhpStorm.
 * User: jeroenfrenken
 * Date: 12/12/2018
 * Time: 02:39
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="user_invitations")
 * @ORM\HasLifecycleCallbacks()
 */
class UserInvitations
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=75)
     */
    private $link;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Organisation", inversedBy="invitations")
     * @ORM\JoinColumn(name="org_id", referencedColumnName="id")
     */
    private $org;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="invitations")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\Column(type="integer", length=3)
     */
    private $access;

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
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     */
    public function setLink($link): void
    {
        $this->link = $link;
    }

    /**
     * @return mixed
     */
    public function getOrg()
    {
        return $this->org;
    }

    /**
     * @param mixed $org
     */
    public function setOrg($org): void
    {
        $this->org = $org;
    }

    /**
     * @return mixed
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * @param mixed $access
     */
    public function setAccess($access): void
    {
        $this->access = $access;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

}