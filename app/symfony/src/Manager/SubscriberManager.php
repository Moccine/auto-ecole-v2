<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Subscriber;
use Doctrine\ORM\EntityManagerInterface;

class SubscriberManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function add(Subscriber $subscriber): void
    {
        $this->entityManager->persist($subscriber);
        $this->entityManager->flush();
    }
}
