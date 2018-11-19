<?php
/**
 * Created by PhpStorm.
 * User: jeroenfrenken
 * Date: 18/11/2018
 * Time: 21:20
 */

namespace App\Controller\DashboardControllers;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{

    public function dashboard() {

        return $this->render('dashboard/dashboard.twig');

    }

}