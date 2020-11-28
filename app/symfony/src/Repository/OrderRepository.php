<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Option;
use App\Entity\Order;
use App\Entity\Purchase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function orderList(int $id)
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('o.reference, o.status, o.createdAt as date, p.amount, op.amount as amountOption')
            ->from(Order::class, 'o')
            ->innerJoin(Purchase::class, 'p', 'with', 'o.id = p.order')
            ->innerJoin(Option::class, 'op', 'with', 'o.id = op.order')
            ->where('o.client = ' . $id)
            ->orderBy('o.createdAt', 'DESC')
            ->getQuery()
            ->getResult();


    }
}
