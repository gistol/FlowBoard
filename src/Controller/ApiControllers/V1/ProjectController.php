<?php
/**
 * Created by PhpStorm.
 * User: jeroenfrenken
 * Date: 22/11/2018
 * Time: 15:55
 */

namespace App\Controller\ApiControllers\V1;


use App\Entity\Organisation;
use App\Entity\Project;
use App\Interfaces\ApiAuthenticationInterface;
use App\Responses\ApiResponses;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;


class ProjectController extends Controller implements ApiAuthenticationInterface
{

    public function getProjects(SerializerInterface $serializer, Request $request, $org) {

        /** @var Organisation $organisation */
        $organisation = $this->get('organisation');

        return ApiResponses::okResponse($organisation->getProjects());

    }

    public function getProject(Request $request, $org, $project) {

        /** @var Project $project */
        $project = $this->get('project');

        return ApiResponses::okResponse($project);

    }

}