<?php
/**
 * Created by PhpStorm.
 * User: jeroenfrenken
 * Date: 09/12/2018
 * Time: 16:42
 */

namespace App\Controller\ApiControllers\V1;


use App\Controller\Utils\PermissionUtils\OrganisationProjectPermission;
use App\Entity\Columns;
use App\Entity\Issue;
use App\Entity\IssueType;
use App\Entity\OrganisationUsers;
use App\Entity\Project;
use App\Entity\User;
use App\Interfaces\ApiAuthenticationInterface;
use App\Responses\ApiResponses;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class IssueController extends Controller implements ApiAuthenticationInterface
{

    public function createIssue(
        ValidatorInterface $validator,
        SerializerInterface $serializer,
        OrganisationProjectPermission $organisationProjectPermission,
        Request $request
    ) {

        /** @var Issue $issue */
        $issue = $serializer->deserialize(
            $request->getContent(), Issue::class, 'json'
        );

        $errors = $validator->validate($issue);

        // Check if there are any error's in the issue
        if (count($errors) > 0) return ApiResponses::badRequest($errors[0]->getPropertyPath(), $errors[0]->getMessage());

        // Set the reporter to the user that is submitting the issue
        $issue->setReporter($this->get('user'));

        // Change a email to a entity also check if the user has access to the organisation
        if ($issue->getAssigned() !== null) {

            /** @var User $assignee */
            $assignee = $this->getDoctrine()->getRepository(User::class)->findOneBy([
                'email' => $issue->getAssigned()
            ]);

            if ($assignee === null) return ApiResponses::badRequest('assigned', 'User not found');

            $res = $organisationProjectPermission->accessProject($assignee, $this->get('project'));

            if ($res === OrganisationUsers::NO_ACCESS) return ApiResponses::badRequest('assigned', 'User not found');

            $issue->setAssigned($assignee);

        }

        // Set the project
        $issue->setProject($this->get('project'));

        // Set the status to a entity
        $status = $this->getDoctrine()->getRepository(IssueType::class)->findOneBy([
            'name' => $issue->getStatus()
        ]);

        if ($status === null) return ApiResponses::badRequest('status', 'Status is not valid');

        $issue->setStatus($status);

        // Set the issue in the first column

        $column = $this->getDoctrine()->getRepository(Columns::class)->findOneBy([
            'project' => $this->get('project'),
            'order' => 0
        ]);

        if ($column === null) return ApiResponses::badRequest('column', 'Creating issue failed could not find the column');

        $issue->setColumn($column);

        // Set the issue key this is the last + 1
        /** @var Issue $lastIssue */
        $lastIssue = $this->getDoctrine()->getRepository(Issue::class)->findOneBy([
            'project' => $this->get('project')
        ], [
            'id' => 'DESC'
        ]);

        $projectId = 0;

        if ($lastIssue !== null) {
            $projectId = $lastIssue->getProjectId() + 1;
        }

        $issue->setProjectId($projectId);

        $em = $this->getDoctrine()->getManager();

        $em->persist($issue);

        $em->flush();

        return ApiResponses::okResponse($issue);

    }

    public function moveIssue(Request $request) {

        $data = json_decode($request->getContent(), true);

        if (!isset($data['column'])) return ApiResponses::badRequest('column', 'property not valid');
        if (!isset($data['issue'])) return ApiResponses::badRequest('issue', 'property not valid');

        $columnId = intval($data['column']);
        $issueId = intval($data['issue']);

        /** @var Issue $issue */
        $issue = $this->getDoctrine()->getRepository(Issue::class)->findOneBy([
            'project' => $this->get('project'),
            'projectId' => $issueId
        ]);

        if ($issue === null) return ApiResponses::badRequest('issue', 'issue not found');

        $column = $this->getDoctrine()->getRepository(Columns::class)->findOneBy([
            'project' => $this->get('project'),
            'order' => $columnId
        ]);

        if ($column === null) return ApiResponses::badRequest('column', 'column not found');

        $em = $this->getDoctrine()->getManager();

        $issue->setColumn($column);

        $em->flush();

        return ApiResponses::okResponse();

    }

    public function updateIssue(Request $request) {

    }

}