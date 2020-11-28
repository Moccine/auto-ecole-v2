<?php

namespace App\Security\Guard;

use App\Service\Security\PasswordService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class AdminAuthenticator extends AbstractGuardAuthenticator
{
    private PasswordService $passwordService;

    private UrlGeneratorInterface $urlGenerator;

    public function __construct(
        PasswordService $passwordService,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->passwordService = $passwordService;
        $this->urlGenerator = $urlGenerator;
    }

    public function supports(Request $request): bool
    {
        if (!$request->request->has('username') || !$request->request->has('password')) {
            return false;
        }

        if ($this->urlGenerator->generate('admin_login') !== $request->getPathInfo()) {
            return false;
        }

        if (!$request->isMethod(Request::METHOD_POST)) {
            return false;
        }

        return true;
    }

    public function start(Request $request, AuthenticationException $exception = null): RedirectResponse
    {
        return new RedirectResponse($this->urlGenerator->generate('admin_login'));
    }

    public function getCredentials(Request $request): array
    {
        $data = [
            'username' => $request->request->get('username'),
            'password' => $request->request->get('password'),
        ];

        return $data;
    }

    public function getUser($credentials, UserProviderInterface $userProvider): Admin
    {
        return $userProvider->loadUserByUsername($credentials['username']);
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        if ($this->passwordService->isValid($user, $credentials['password'])) {
            return true;
        }

        return false;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey): RedirectResponse
    {
        return new RedirectResponse($this->urlGenerator->generate('easyadmin'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): RedirectResponse
    {
        return new RedirectResponse($this->urlGenerator->generate('admin_login'));
    }

    public function supportsRememberMe(): bool
    {
        return false;
    }
}
