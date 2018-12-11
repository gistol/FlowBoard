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
use Symfony\Component\Validator\Validator\ValidatorInterface;


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

    public function createProject(
        ValidatorInterface $validator,
        SerializerInterface $serializer,
        Request $request
    ) {

        /** @var Project $project */
        $project = $serializer->deserialize(
            $request->getContent(), Project::class, 'json'
        );

        $errors = $validator->validate($project);

        // Check if there are any error's in the issue
        if (count($errors) > 0) return ApiResponses::badRequest($errors[0]->getPropertyPath(), $errors[0]->getMessage());

        $projectName = $this->getDoctrine()->getRepository(Project::class)->findOneBy([
            'name' => $project->getName()
        ]);

        if ($projectName !== null) return ApiResponses::badRequest('name', 'Project name taken');

        $key = strtoupper(substr($project->getName(), 0, 2));

        $keySet = false;

        for ($i = 0; $i < 3; $i++) {

            $keyFound = $this->getDoctrine()->getRepository(Project::class)->findHighestKey(
                $key, $this->get('organisation')
            );

            if (count($keyFound) === 0) break;

            $keyIncrement = intval(substr($keyFound[0]->getKey(), -2));
            $keyIncrement++;

            if ($keyIncrement < 100) {
                $keySet = true;
                $key = $key . $keyIncrement;
            }



        }

        if ($keySet === false) return ApiResponses::badRequest('name', 'Choose a different project name');

        $project->setKey($key);
        $project->setOrganisation($this->get('organisation'));

        $em = $this->getDoctrine()->getManager();

        $em->persist($project);

        $em->flush();

        return ApiResponses::okResponse($project);

    }

}