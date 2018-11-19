<?php
/**
 * Created by PhpStorm.
 * User: jeroenfrenken
 * Date: 15/11/2018
 * Time: 23:12
 */

namespace App\Controller\AuthenticationControllers;


use App\Entity\User;
use App\Form\Authentication\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RegisterController extends Controller
{

    public function register(Request $request) {


        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setIsEnabled(1);
            $user->setPassword(password_hash($user->getPassword(), PASSWORD_BCRYPT));

            $user->setEmail(strtolower($user->getEmail()));

            $em = $this->getDoctrine()->getManager();

            $em->persist($user);

            try {

                $em->flush();

            } catch (\Exception $exception) {


                echo 'ohjee'; exit;
                //hier kan het mis gaan

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