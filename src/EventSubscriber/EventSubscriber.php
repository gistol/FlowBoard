<?php
/**
 * Created by PhpStorm.
 * User: jeroenfrenken
 * Date: 22/02/2018
 * Time: 16:22
 */
namespace App\EventSubscriber;

use App\Entity\UserToken;
use App\Responses\ApiResponses;
use App\Interfaces\ApiAuthenticationInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EventSubscriber implements EventSubscriberInterface
{

    /** @var ContainerInterface $container */
    private $container;

    /**
     * Loads the container
     *
     * TokenSubscriber constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onKernelController(FilterControllerEvent $event)
    {

        $controller = $event->getController();

        if(!is_array($controller)) return;

        if ($controller[0] instanceof ApiAuthenticationInterface) {

            $request = $event->getRequest();

            if ($request->isMethod('options')) {
                return $event->setController(function () {
                    return ApiResponses::okResponse();
                });
            }

            $token = $request->headers->get('authentication');

            if ($token === null) {
                return $event->setController(function () {
                    return ApiResponses::notAuthorized();
                });
            };

            $doctrine = $this->container->get('doctrine');

            $user = $doctrine->getRepository(UserToken::class)->findOneBy([
                'token' => $token
            ]);


            if ($user === null) {

                return $event->setController(function () {
                    return ApiResponses::notAuthorized();
                });

            }

            $this->container->set('user', $user->getUser());


        }

    }

    public function onKernelResponse(FilterResponseEvent $event)
    {

        $responseHeaders = $event->getResponse()->headers;

        $responseHeaders->set('Access-Control-Allow-Origin', '*');
        $responseHeaders->set('Access-Control-Allow-Headers', "Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers, Authentication");
        $responseHeaders->set('Access-Control-Allow-Credentials', 'true');

    }

    public static function getSubscribedEvents()
    {

        return array(
            KernelEvents::CONTROLLER => 'onKernelController',
            KernelEvents::RESPONSE => 'onKernelResponse'
        );

    }

}