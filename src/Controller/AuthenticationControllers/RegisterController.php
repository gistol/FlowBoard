<?php
/**
 * Created by PhpStorm.
 * User: jeroenfrenken
 * Date: 15/11/2018
 * Time: 23:12
 */

namespace App\Controller\AuthenticationControllers;


use App\Entity\OrganisationUsers;
use App\Entity\User;
use App\Entity\UserInvitations;
use App\Form\Authentication\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RegisterController extends Controller
{

    public function register(Request $request) {

        $session = $this->get('session');

        if ($request->get('hash') !== null) {
            $session->set('hash', $request->get('hash'));
        }

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setIsEnabled(1);
            $user->setPassword(password_hash($user->getPassword(), PASSWORD_BCRYPT));

            $user->setEmail(strtolower($user->getEmail()));

            $em = $this->getDoctrine()->getManager();

            $em->persist($user);

            if ($session->get('hash') !== null) {
                $hash = $session->get('hash');

                /** @var UserInvitations $found */
                $found = $this->getDoctrine()->getRepository(UserInvitations::class)->findOneBy([
                    'link' => $hash
                ]);

                if ($found !== null) {

                    $access = new OrganisationUsers();
                    $access->setOrganisation($found->getOrg());
                    $access->setUser($user);
                    $access->setAccess($found->getAccess());

                    $em->persist($access);
                    $em->remove($found);

                }

                $session->remove('hash');

            }







            try {

                $em->flush();

            } catch (\Exception $exception) {


                echo 'error'; exit;

            }

            /*
             * TODO
             * Nou moet er ook een melding komen enz
             */

            return $this->redirectToRoute('login');

        }

        return $this->render('authentication/register.twig', [
            'form' => $form->createView()
        ]);

    }

}