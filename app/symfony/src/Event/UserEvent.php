<?php

declare(strict_types=1);

namespace App\Event;

use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class UserEvent extends Event
{
    public const REGISTERED = 'app.user.registered';
    public const REGISTERED_CONFIRMED = 'app.user.registered.confirmed';
    public const LOGGED = 'app.user.logged';
    public const RESETED = 'app.user.password.reseted';

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }
}
