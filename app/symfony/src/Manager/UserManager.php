<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Incident;
use App\Entity\Token;
use App\Entity\User;
use App\Event\UserEvent;
use App\Repository\TokenRepository;
use App\Security\Guard\UserAuthenticator;
use App\Service\Mailer\Sender;
use App\Service\Security\PasswordService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class UserManager
{
    private EntityManagerInterface $em;

    private PasswordService $passwordService;

    private RequestStack $request;

    private EventDispatcherInterface $eventDispatcher;

    private Sender $sender;

    private GuardAuthenticatorHandler $authenticatorHandler;

    private UserAuthenticator $authenticator;

    private TokenRepository $tokenRepository;

    private TokenManager $tokenManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        PasswordService $passwordService,
        RequestStack $requestStack,
        EventDispatcherInterface $eventDispatcher,
        GuardAuthenticatorHandler $authenticatorHandler,
        Sender $sender,
        UserAuthenticator $authenticator,
        TokenRepository $tokenRepository,
        TokenManager $tokenManager
    ) {
        $this->em = $entityManager;
        $this->passwordService = $passwordService;
        $this->request = $requestStack;
        $this->eventDispatcher = $eventDispatcher;
        $this->sender = $sender;
        $this->authenticatorHandler = $authenticatorHandler;
        $this->authenticator = $authenticator;
        $this->tokenRepository = $tokenRepository;
        $this->tokenManager = $tokenManager;
    }

    public function create(User $user): void
    {
        try{
            $this->encodePassword($user, $user->getPlainPassword());
            $this->em->persist($user);
            $this->em->flush();
            $this->tokenManager->create(Token::TYPE_CONFIRM, $user);

            $this->eventDispatcher->dispatch(
                new UserEvent($user),
                UserEvent::REGISTERED
            );
        }catch (\Exception $exception){
            dd($exception);
        }

    }

    private function encodePassword(User $user, string $password): void
    {
        $user->setPassword($this->passwordService->encode($user, trim($password)));
    }

    public function resetPassword(User $user, string $password, Token $token): void
    {
        $this->encodePassword($user, $password);

        $this->eventDispatcher->dispatch(
            new UserEvent($user),
            UserEvent::RESETED
        );

        $this->authentificate($token->getUser());
    }

    public function registrationConfirm(Token $token): void
    {
        $this->eventDispatcher->dispatch(
            new UserEvent($token->getUser()),
            UserEvent::REGISTERED_CONFIRMED
        );
    }

    public function authentificate(User $user): void
    {
        $this->authenticatorHandler->authenticateUserAndHandleSuccess(
            $user,
            $this->request,
            $this->authenticator,
            'main'
        );
    }

    public function getTokenByUser(User $user)
    {
        return $this->tokenRepository->findOneByUser($user);
    }

    public function getListIncidents()
    {
        return $this->em->getRepository(Incident::class)->findAll();
    }

    public function getIncident(Incident $incident)
    {
        return $this->em->getRepository(Incident::class)->find($incident);
    }

    public function closeIncident(Incident $incident)
    {
        $incident->setStatus(Incident::STATUS_CLOSE);
        $this->em->flush();
    }

    public function changePassword(User $user, $password): void
    {
        $this->encodePassword($user, $password);

        $this->em->persist($user);
        $this->em->flush();
    }
}
