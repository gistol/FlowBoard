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
 * @ORM\Entity()
 * @ORM\Table(name="issue")
 */
class Issue implements \JsonSerializable
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $projectId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="issues")
     * @ORM\JoinColumn(name="project", referencedColumnName="id")
     */
    private $project;

    /**
     * @Assert\NotBlank(
     *     message="Title can not be blank"
     * )
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "Your issue title must be at least {{ limit }} characters long",
     *      maxMessage = "Your issue title cannot be longer than {{ limit }} characters"
     * )
     * @ORM\Column(type="string", length=100)
     */
    private $title;

    /**
     * @Assert\Length(
     *      max = 100,
     *      maxMessage = "Your issue comment cannot be longer than {{ limit }} characters"
     * )
     * @ORM\Column(type="text", length=1000, nullable=true)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Columns", inversedBy="issues")
     * @ORM\JoinColumn(name="column_id", referencedColumnName="id")
     */
    private $column;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="assigndIssues")
     * @ORM\JoinColumn(name="assigned", referencedColumnName="id")
     */
    private $assigned;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="reportedIssues")
     * @ORM\JoinColumn(name="reporter", referencedColumnName="id")
     */
    private $reporter;

    /**
     * @Assert\NotBlank(
     *     message="status can not be blank"
     * )
     * @ORM\ManyToOne(targetEntity="App\Entity\IssueType", inversedBy="issues")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * Issue constructor
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
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
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
    public function getProjectId()
    {
        return $this->projectId;
    }

    /**
     * @param mixed $projectId
     */
    public function setProjectId($projectId): void
    {
        $this->projectId = $projectId;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment): void
    {
        $this->comment = $comment;
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
    public function getAssigned()
    {
        return $this->assigned;
    }

    /**
     * @param mixed $assigned
     */
    public function setAssigned($assigned): void
    {
        $this->assigned = $assigned;
    }

    /**
     * @return mixed
     */
    public function getReporter()
    {
        return $this->reporter;
    }

    /**
     * @param mixed $reporter
     */
    public function setReporter($reporter): void
    {
        $this->reporter = $reporter;
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
            '_id' => $this->getProjectId(),
            'key' => $this->getProject()->getKey() . '-' . $this->getProjectId(),
            'title' => $this->getTitle(),
            'comment' => $this->getComment(),
            'status' => $this->getStatus(),
            'created' => $this->getCreated(),
            'assignee' => $this->getAssigned(),
            'reporter' => $this->getReporter()
        ];
    }

}