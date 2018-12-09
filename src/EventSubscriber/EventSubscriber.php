<?php
/**
 * Created by PhpStorm.
 * User: jeroenfrenken
 * Date: 22/10/2018
 * Time: 16:22
 */
namespace App\EventSubscriber;

use App\Entity\Project;
use App\Entity\UserToken;
use App\Entity\Organisation;
use App\Responses\ApiResponses;
use App\Entity\OrganisationUsers;
use App\Interfaces\ApiAuthenticationInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Controller\Utils\PermissionUtils\OrganisationProjectPermission;

class EventSubscriber implements EventSubscriberInterface
{

    /** @var ContainerInterface $container */
    private $container;

    /**
     * Loads the container
     *
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

            // Always let options requests pass else there are problems in the front-end
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

            // Get the user by token
            $user = $doctrine->getRepository(UserToken::class)->findOneBy([
                'token' => $token
            ]);


            // not authorized as the user is not found
            if ($user === null) {

                return $event->setController(function () {
                    return ApiResponses::notAuthorized();
                });

            }

            // set the user in the container for in controller usage
            $this->container->set('user', $user->getUser());

            /*
             * Additional permission checking
             */

            // Check if the route contains the params org and / or project

            $orgName = $request->attributes->get('org');

            $projectName = $request->attributes->get('project');

            if ($orgName !== null || $projectName !== null) {

                $access = OrganisationUsers::NO_ACCESS;

                $organisation = $doctrine->getRepository(Organisation::class)->findOneBy([
                    'name' => $orgName
                ]);

                if ($organisation === null) return ApiResponses::badRequest('org', 'Organisation not found');

                $this->container->set('organisation', $organisation);

                // Permission tool is used get the access level

                /** @var OrganisationProjectPermission $permissionUtil */
                $permissionUtil = $this->container->get('App\Controller\Utils\PermissionUtils\OrganisationProjectPermission');

                // Check for the organisation access since a org resource is asked
                if ($orgName !== null && $projectName === null) {

                    $access = $permissionUtil->accessOrganisation($user->getUser(), $organisation);

                    // Set org access to the container for use in controllers
                    $this->container->set('organisation_access', $access);

                }

                // Check the project permission since a project resource is asked
                if ($orgName !== null && $projectName !== null) {

                    $project = $doctrine->getRepository(Project::class)->findOneBy([
                        'name' => $projectName
                    ]);

                    if ($project === null) return 0; //TODO: implement bad request

                    $access = $permissionUtil->accessProject($user->getUser(), $project);

                    $this->container->set('project', $project);

                    $this->container->set('project_access', $access);

                }

                /*
                 * Access calculation
                 *
                 * NO_ACCESS block all requests
                 * ACCESS_READ block all request expect get
                 *
                 * Additional access checking is done in the controller
                 */

                switch ($access) {
                    case OrganisationUsers::NO_ACCESS:
                        $block = true;
                        break;
                    case OrganisationUsers::ACCESS_READ:
                        $block = $request->getMethod() !== 'GET';
                        break;
                    default:
                        $block = false;
                        break;
                };

                if ($block) {
                    return $event->setController(function () {
                        return ApiResponses::forbidden();
                    });
                }


            }


        }

    }

    public function onKernelResponse(FilterResponseEvent $event)
    {

        // Set some headers to please the browser :)

        $responseHeaders = $event->getResponse()->headers;

        $responseHeaders->set('Access-Control-Allow-Origin', '*');
        $responseHeaders->set('Access-Control-Allow-Headers', "Access-Control-Allow-Methods, Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers, Authentication");
        $responseHeaders->set('Access-Control-Allow-Credentials', 'true');
        $responseHeaders->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');

    }

    public static function getSubscribedEvents()
    {

        return array(
            KernelEvents::CONTROLLER => 'onKernelController',
            KernelEvents::RESPONSE => 'onKernelResponse'
        );

    }

}