<?php

declare(strict_types=1);

namespace App\Event;

use App\Entity\Operator;
use Symfony\Contracts\EventDispatcher\Event;

class OperatorEvent extends Event
{
    public const LOGGED = 'app.operator.logged';

    private Operator $operator;

    public function __construct(Operator $operator)
    {
        $this->operator = $operator;
    }

    public function getOperator()
    {
        return $this->operator;
    }
}
