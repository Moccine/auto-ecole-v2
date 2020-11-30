<?php

namespace App\EventSubscriber;

use App\Entity\Admin;
use App\Manager\AdminManager;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private AdminManager $adminManager;

    public function __construct(AdminManager $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['createAdminPassword'],
            BeforeEntityUpdatedEvent::class => ['updateAdminPassword'],
        ];
    }

    public function createAdminPassword(BeforeEntityPersistedEvent $event)
    {
        $this->setAdminPassword($event);
    }

    public function updateAdminPassword(BeforeEntityUpdatedEvent $event)
    {
        $this->setAdminPassword($event);
    }

    protected function setAdminPassword($event)
    {
        $admin = $event->getEntityInstance();

        if (false == ($admin instanceof Admin)) {
            return;
        }

        $this->adminManager->encode($admin);
    }
}
