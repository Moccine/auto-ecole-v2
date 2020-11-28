<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class IncidentVoter extends Voter
{
    public const INCIDENT_CREATE = 'create';
    public const INCIDENT_CONSULT = 'consult';
    public const INCIDENT_CONSULT_LISTING = 'listing';
    public const INCIDENT_CLOSE = 'close';
    public const INCIDENT_UPLOAD = 'upload';

    protected array $attributes = [
        self::INCIDENT_CREATE,
        self::INCIDENT_CONSULT,
        self::INCIDENT_CONSULT_LISTING,
        self::INCIDENT_CLOSE,
        self::INCIDENT_UPLOAD,
    ];

    protected AuthorizationCheckerInterface $authChecker;

    public function __construct(AuthorizationCheckerInterface $authChecker)
    {
        $this->authChecker = $authChecker;
    }

    protected function supports($attribute, $subject): bool
    {
        if (!\in_array($attribute, $this->attributes)) {
            return false;
        }

        return true;
    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::INCIDENT_CREATE:
                return $this->canCreate();
            case self::INCIDENT_CONSULT:
                return $this->canConsult();
            case self::INCIDENT_CONSULT_LISTING:
                return $this->canConsultListing();
            case self::INCIDENT_CLOSE:
                return $this->canClose();
            case self::INCIDENT_UPLOAD:
                return $this->canUpload();
            default:
                return false;
        }
    }

    public function canCreate(): bool
    {
        return $this->authChecker->isGranted('ROLE_USER');
    }

    public function canConsult(): bool
    {
        return $this->authChecker->isGranted('ROLE_OPERATOR') || $this->authChecker->isGranted('ROLE_USER');
    }

    public function canConsultListing(): bool
    {
        return $this->authChecker->isGranted('ROLE_OPERATOR') || $this->authChecker->isGranted('ROLE_USER');
    }

    public function canClose(): bool
    {
        return $this->authChecker->isGranted('ROLE_OPERATOR');
    }

    public function canUpload(): bool
    {
        return $this->authChecker->isGranted('ROLE_OPERATOR');
    }
}
