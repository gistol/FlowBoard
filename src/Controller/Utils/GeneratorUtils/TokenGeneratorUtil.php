<?php
/**
 * Created by PhpStorm.
 * User: jeroenfrenken
 * Date: 18/11/2018
 * Time: 20:34
 */

namespace App\Controller\Utils\GeneratorUtils;


use App\Entity\User;
use App\Entity\UserToken;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TokenGeneratorUtil
{

    private $_doctrine;

    public function __construct(ContainerInterface $container) {

        $this->_doctrine = $container->get('doctrine');

    }

    public function generateToken(User $user, String $ip) {

        $token = new UserToken();

        $token->setIp($ip);
        $token->setUser($user);
        $token->setToken(uniqid());

        $em = $this->_doctrine->getManager();

        $em->persist($token);

        $em->flush();


        //TODO: beter token creation and splitting up and checking for active token
        return $token->getToken();

    }

}