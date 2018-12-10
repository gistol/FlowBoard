<?php
/**
 * Created by PhpStorm.
 * User: jeroenfrenken
 * Date: 10/12/2018
 * Time: 21:24
 */

namespace App\Repository;


use App\Entity\Columns;
use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class ColumnsRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Columns::class);
    }

    public function findOrderGreaterThan(int $order, Project $project) {

        $qb = $this->createQueryBuilder('c')
            ->andWhere('c.order >= :order')
            ->andWhere('c.project = :project')
            ->setParameter('order', $order)
            ->setParameter('project', $project)
            ->orderBy('c.order', 'ASC')
            ->getQuery();

        return $qb->execute();

    }

}