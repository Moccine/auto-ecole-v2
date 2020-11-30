<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Event\OperatorEvent;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class OperatorSubscriber implements EventSubscriberInterface
{
    private EntityManager $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            OperatorEvent::LOGGED => 'onLogged',
        ];
    }

    public function onLogged(OperatorEvent $event): void
    {
        $operator = $event->getOperator();
        if (!$operator->getAgency()) {
            $operator->setAgency($operator->getAgencies()->first());
            $this->em->flush();
        }
    }
}
