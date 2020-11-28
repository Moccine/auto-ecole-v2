<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Admin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminManager
{
    private EntityManagerInterface $em;
    private UserPasswordEncoderInterface $encoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $entityManager;
        $this->encoder = $encoder;
    }

    public function encode(Admin $admin): void
    {
        $this->encodePassword($this->encoder, $admin);

        $this->em->persist($admin);
        $this->em->flush();
    }

    public function encodePassword(UserPasswordEncoderInterface $encoder, Admin $admin)
    {
        $encoded = $encoder->encodePassword($admin, $admin->getPlainPassword());
        $admin->setPassword($encoded);
    }
}
