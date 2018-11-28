<?php
/**
 * Created by PhpStorm.
 * User: jeroenfrenken
 * Date: 26/11/2018
 * Time: 21:41
 */

namespace App\Controller\Utils\PermissionUtils;


use App\Entity\User;
use App\Entity\Project;
use App\Entity\Organisation;
use App\Entity\ProjectUsers;
use App\Entity\OrganisationUsers;
use Symfony\Component\DependencyInjection\ContainerInterface;

class OrganisationProjectPermission
{

    private $_doctrine;

    public function __construct(ContainerInterface $container)
    {
        $this->_doctrine = $container->get('doctrine');
    }


    public function accessOrganisation(User $user, Organisation $organisation) {

        $res = $this->_doctrine->getRepository(OrganisationUsers::class)->findOneBy([
            'user' => $user,
            'organisation' => $organisation
        ]);

        if ($res === null) return 0;

        return $res->getAccess();

    }

    public function accessProject(User $user, Project $project) {

        $res = $this->_doctrine->getRepository(ProjectUsers::class)->findOneBy([
            'user' => $user,
            'project' => $project
        ]);

        if ($res === null) {
            return $this->accessOrganisation($user, $project->getOrganisation());
        }

        return $res->getAccess();

    }

}