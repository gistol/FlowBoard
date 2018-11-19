<?php
/**
 * Created by PhpStorm.
 * User: jeroenfrenken
 * Date: 15/11/2018
 * Time: 20:29
 */
namespace App\Controller\AuthenticationControllers;

use App\Entity\User;
use App\Form\Authentication\LoginFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends Controller
{

    public function login(Request $request) {

        $user = new User();
        $form = $this->createForm(LoginFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $doctrine = $this->getDoctrine();

            $account = $doctrine->getRepository(User::class)->findOneBy([
                'email' => strtolower($user->getEmail())
            ]);

            if ($account !== null && password_verify($user->getPassword(), $account->getPassword())) {

                $token = $this->get('App\Controller\Utils\GeneratorUtils\TokenGeneratorUtil')->generateToken(
                    $account,
                    $request->getClientIp()
                );

                return $this->redirectToRoute('main_dashboard', [
                    'token' => $token
                ]);

            }

            /*
             * Hier gaat het sowieso fout dus return
             */

            return $this->render('authentication/login.twig', [
                'form' => $form->createView(),
                'error' => 'Email or password is not correct'
            ]);

        }

        return $this->render('authentication/login.twig', [
            'form' => $form->createView()
        ]);

    }

}