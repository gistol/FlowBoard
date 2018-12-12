<?php
/**
 * Created by PhpStorm.
 * User: jeroenfrenken
 * Date: 12/12/2018
 * Time: 02:54
 */

namespace App\Controller\AuthenticationControllers;


use App\Entity\OrganisationUsers;
use App\Entity\UserInvitations;
use App\Responses\ApiResponses;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{

    public function invitationAccept($hash) {

        /** @var UserInvitations $found */
        $found = $this->getDoctrine()->getRepository(UserInvitations::class)->findOneBy([
            'link' => $hash
        ]);

        if ($found === null) return $this->redirectToRoute('login');

        if ($found->getUser() === null) {
            return $this->redirectToRoute('register', [
                'hash' => $hash
            ]);
        }

        $access = new OrganisationUsers();
        $access->setUser($found->getUser());
        $access->setOrganisation($found->getOrg());
        $access->setAccess($found->getAccess());

        $em = $this->getDoctrine()->getManager();

        $em->persist($access);

        $em->remove($found);

        $em->flush();

        $pName = $access->getOrganisation()->getName();

        $this->addFlash('1', "login to join $pName");

        return $this->redirectToRoute('login');



    }

}