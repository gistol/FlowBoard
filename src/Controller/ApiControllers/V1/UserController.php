<?php
/**
 * Created by PhpStorm.
 * User: jeroenfrenken
 * Date: 12/12/2018
 * Time: 02:24
 */

namespace App\Controller\ApiControllers\V1;


use App\Controller\Utils\PermissionUtils\OrganisationProjectPermission;
use App\Entity\OrganisationUsers;
use App\Entity\User;
use App\Entity\UserInvitations;
use App\Interfaces\ApiAuthenticationInterface;
use App\Responses\ApiResponses;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller implements ApiAuthenticationInterface
{

    public function invite(
        OrganisationProjectPermission $permission,
        Request $request
    ) {

        $data = json_decode($request->getContent(), true);

        if (!isset($data['email'])) return ApiResponses::badRequest('email', 'email not valid');
        if (!isset($data['access'])) return ApiResponses::badRequest('access', 'access not valid');

        $email = $data['email'];
        $access = intval($data['access']);

        if (
            $access !== OrganisationUsers::ACCESS_READ &&
            $access !== OrganisationUsers::ACCESS_WRITE &&
            $access !== OrganisationUsers::ACCESS_OWNER
        ) return ApiResponses::badRequest('access', 'access not valid');

        if (
            !filter_var($email, FILTER_VALIDATE_EMAIL)
        ) return ApiResponses::badRequest('email', 'email not valid');

        if (
            $email === $this->get('user')->getEmail()
        ) return ApiResponses::badRequest('email', 'can not invite own account');

        /** @var User $userFound */
        $userFound = $this->getDoctrine()->getRepository(User::class)->findOneBy([
            'email' => $email
        ]);

        if ($userFound !== null) {

            $accessDb = $permission->accessOrganisation($userFound, $this->get('organisation'));

            if (
                $accessDb !== OrganisationUsers::NO_ACCESS
            ) return ApiResponses::badRequest('email', 'User already in organisation');

        }

        $invitation = new UserInvitations();
        $invitation->setAccess($access);
        $invitation->setOrg($this->get('organisation'));
        $invitation->setUser($userFound);
        $invitation->setLink(md5($email . time() . uniqid()));

        $em = $this->getDoctrine()->getManager();


        $em->persist($invitation);

        $em->flush();

        return ApiResponses::okResponse();

    }

    public function update(
        Request $request
    ) {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['email'])) return ApiResponses::badRequest('email', 'email not valid');
        if (!isset($data['access'])) return ApiResponses::badRequest('access', 'access not valid');

        $email = $data['email'];
        $access = intval($data['access']);

        if (
            $access !== OrganisationUsers::ACCESS_READ &&
            $access !== OrganisationUsers::ACCESS_WRITE &&
            $access !== OrganisationUsers::ACCESS_OWNER
        ) return ApiResponses::badRequest('access', 'access not valid');

        if (
            !filter_var($email, FILTER_VALIDATE_EMAIL)
        ) return ApiResponses::badRequest('email', 'email not valid');

        if (
            $email === $this->get('user')->getEmail()
        ) return ApiResponses::badRequest('email', 'Can not update own account');

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy([
            'email' => $email
        ]);

        if ($user === null) return ApiResponses::badRequest('email', 'User not found');

        $accessUser = $this->getDoctrine()->getRepository(OrganisationUsers::class)->findOneBy([
            'user' => $user,
            'organisation' => $this->get('organisation')
        ]);

        if ($accessUser === null) return ApiResponses::badRequest('email', 'User not found');

        $em = $this->getDoctrine()->getManager();

        $accessUser->setAccess($access);

        $em->flush();

        return ApiResponses::okResponse();

    }

}