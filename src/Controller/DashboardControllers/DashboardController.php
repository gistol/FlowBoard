<?php
/**
 * Created by PhpStorm.
 * User: jeroenfrenken
 * Date: 18/11/2018
 * Time: 21:20
 */

namespace App\Controller\DashboardControllers;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{

    public function dashboard(Request $request) {

        $token = $request->get('token');

        $session = $this->get('session');

        if ($token !== null) {

            $session->set('token', $token);

            return $this->redirectToRoute('main_dashboard');

        }

        if ($session->get('token') === null) return $this->redirectToRoute('login');

        return $this->render('dashboard/dashboard.twig', [
            'token' => $session->get('token')
        ]);

    }

    public function renderImgUser($email) {


        $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) );


        $content = file_get_contents($grav_url);

        return new Response($content, Response::HTTP_OK, [
            'content-type' => 'image/png'
        ]);

    }

}