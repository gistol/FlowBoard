<?php
/**
 * Created by PhpStorm.
 * User: jeroenfrenken
 * Date: 15/11/2018
 * Time: 23:12
 */

namespace App\Controller\AuthenticationControllers;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RegisterController extends Controller
{

    public function register() {

        return $this->render('register.twig');

    }

}