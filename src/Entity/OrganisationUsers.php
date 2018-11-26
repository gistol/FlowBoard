<?php
/**
 * Created by PhpStorm.
 * User: jeroenfrenken
 * Date: 22/11/2018
 * Time: 11:42
 */

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="organisation_users")
 */
class OrganisationUsers
{

    /*
     * No Access is because the person is allowed to a project but not to the organisation
     */
    public const NO_ACCESS = 0;
    public const ACCESS_READ = 10;
    public const ACCESS_WRITE = 50;
    public const ACCESS_OWNER = 100;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Organisation")
     * @ORM\JoinColumn(name="org_id", referencedColumnName="id")
     */
    private $organisation;

    /**
     * @ORM\Column(type="integer", length=3)
     */
    private $access;

    /**
     * @ORM\Column(type="datetime")
     */
    private $joined;

    public function __construct()
    {
        $this->setJoined(new \DateTime('now'));
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
    public function getJoined()
    {
        return $this->joined;
    }

    /**
     * @param mixed $joined
     */
    public function setJoined($joined): void
    {
        $this->joined = $joined;
    }

}