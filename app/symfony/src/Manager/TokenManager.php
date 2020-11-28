<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Token;
use App\Entity\User;
use App\Service\Security\TokenService;
use Doctrine\ORM\EntityManagerInterface;

class TokenManager
{
    private EntityManagerInterface $em;

    private TokenService $tokenService;

    public function __construct(
        EntityManagerInterface $entityManager,
        TokenService $tokenService
    ) {
        $this->em = $entityManager;
        $this->tokenService = $tokenService;
    }

    public function create(string $type, User $user): Token
    {
        $token = new Token();

        $token->setGeneratedAt(new \DateTime());

        $token->setUser($user);
        $token->setType($type);
        $token->setValue($this->tokenService->generate());

        $this->em->persist($token);
        $this->em->flush();

        return $token;
    }
}
