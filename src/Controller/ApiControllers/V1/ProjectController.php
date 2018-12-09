<?php
/**
 * Created by PhpStorm.
 * User: jeroenfrenken
 * Date: 22/11/2018
 * Time: 15:55
 */

namespace App\Controller\ApiControllers\V1;


use App\Entity\Organisation;
use App\Entity\OrganisationUsers;
use App\Entity\Project;
use App\Entity\ProjectUsers;
use App\Interfaces\ApiAuthenticationInterface;
use App\Responses\ApiResponses;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;


class ProjectController extends Controller implements ApiAuthenticationInterface
{

    public function getProjects() {

        /** @var Organisation $organisation */
        $organisation = $this->get('organisation');

        return ApiResponses::okResponse([
            'access' => $this->get('organisationAccess'),
            'projects' => $organisation->getProjects()
        ]);

    }

    public function getProject() {

        /** @var Project $project */
        $project = $this->get('project');

        return ApiResponses::okResponse([
            'access' => $this->get('projectAccess'),
            'project' => $project
        ]);

    }

    public function getProjectUsers() {

        $orgUsers = $this->getDoctrine()->getRepository(OrganisationUsers::class)->findBy([
            'organisation' => $this->get('organisation')
        ]);

        $projUsers = $this->getDoctrine()->getRepository(ProjectUsers::class)->findBy([
            'project' => $this->get('project')
        ]);

        $users = [];

        foreach ($orgUsers as $user) $users[] = $user->getUser();
        foreach ($projUsers as $user) $users[] = $user->getUser();

        return ApiResponses::okResponse($users);

    }

}