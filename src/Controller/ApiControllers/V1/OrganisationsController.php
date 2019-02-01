<?php
/**
 * Created by PhpStorm.
 * User: jeroenfrenken
 * Date: 11/12/2018
 * Time: 23:20
 */

namespace App\Controller\ApiControllers\V1;


use App\Entity\Organisation;
use App\Entity\OrganisationUsers;
use App\Interfaces\ApiAuthenticationInterface;
use App\Responses\ApiResponses;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class OrganisationsController extends Controller implements ApiAuthenticationInterface
{

    public function getOrganisations() {

        $res = $this->getDoctrine()->getRepository(OrganisationUsers::class)->findBy([
            'user' => $this->get('user')
        ]);

        foreach ($res as $value) {

            $value->getOrganisation()->setProjects([]);

        }

        return ApiResponses::okResponse($res);

    }

    public function createOrganisation(
        ValidatorInterface $validator,
        SerializerInterface $serializer,
        Request $request
    ) {

        /** @var Organisation $org */
        $org = $serializer->deserialize(
            $request->getContent(), Organisation::class, 'json'
        );

        $errors = $validator->validate($org);

        // Check if there are any error's in the organisation
        if (count($errors) > 0) return ApiResponses::badRequest($errors[0]->getPropertyPath(), $errors[0]->getMessage());

        $found = $this->getDoctrine()->getRepository(Organisation::class)->findOneBy([
            'name' => $org->getName()
        ]);

        if ($found !== null) return ApiResponses::badRequest('name', 'Name not available');

        $em = $this->getDoctrine()->getManager();

        $em->persist($org);

        $orgAccess = new OrganisationUsers();
        $orgAccess->setUser($this->get('user'));
        $orgAccess->setOrganisation($org);
        $orgAccess->setAccess(OrganisationUsers::ACCESS_OWNER);

        $em->persist($orgAccess);

        $em->flush();

        return ApiResponses::okResponse($org);

    }

    public function getOrganisation() {

        $org = $this->get('organisation');

        $org->setProjects([]);

        return ApiResponses::okResponse($org);

    }

}