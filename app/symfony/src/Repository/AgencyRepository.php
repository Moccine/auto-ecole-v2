<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Agency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AgencyRepository|null find($id, $lockMode = null, $lockVersion = null)
 * @method AgencyRepository|null findOneBy(array $criteria, array $orderBy = null)
 * @method AgencyRepository[]    findAll()
 * @method AgencyRepository[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgencyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Agency::class);
    }
}
