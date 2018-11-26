<?php
/**
 * Created by PhpStorm.
 * User: jeroenfrenken
 * Date: 22/11/2018
 * Time: 15:55
 */

namespace App\Controller\ApiControllers\V1;


use App\Interfaces\ApiAuthenticationInterface;
use App\Responses\ApiResponses;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProjectController extends Controller implements ApiAuthenticationInterface
{

    public function getProjects(Request $request, $org) {

        return ApiResponses::okResponse();

    }

    public function getProject(Request $request, $org, $project) {



    }

}