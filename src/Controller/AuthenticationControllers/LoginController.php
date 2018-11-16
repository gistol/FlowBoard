<?php
/**
 * Created by PhpStorm.
 * User: jeroenfrenken
 * Date: 15/11/2018
 * Time: 20:29
 */
namespace App\Controller\AuthenticationControllers;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LoginController extends Controller
{

    public function login() {

        return $this->render('login.twig', [

        ]);

    }

}