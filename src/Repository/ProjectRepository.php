<?php
/**
 * Created by PhpStorm.
 * User: jeroenfrenken
 * Date: 11/12/2018
 * Time: 07:51
 */

namespace App\Repository;


use App\Entity\Organisation;
use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Persistence\ManagerRegistry;

class ProjectRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    public function findHighestKey(string $key, Organisation $organisation) {

        $qb = $this->createQueryBuilder('p')
                ->andWhere('p.organisation = :org')
                ->andWhere('p.key LIKE :key')
                ->setParameter('org', $organisation)
                ->setParameter('key', '%' . $key . '%')
                ->orderBy('p.id', Criteria::DESC)
                ->setMaxResults(1)
                ->getQuery();

        return $qb->execute();

    }

}