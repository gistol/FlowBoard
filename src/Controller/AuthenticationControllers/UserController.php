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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{

    public function invitationAccept($hash) {

        /** @var UserInvitations $found */
        $found = $this->getDoctrine()->getRepository(UserInvitations::class)->findOneBy([
            'link' => $hash
        ]);

        if ($found === null) return $this->redirectToRoute('login');

        $pName = $found->getOrg()->getName();

        if ($found->getUser() === null) {
            $this->addFlash('1', "Register to join $pName");

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

        $this->addFlash('1', "login to join $pName");

        return $this->redirectToRoute('login');
    }

}