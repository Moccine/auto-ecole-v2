<?php

declare(strict_types=1);

namespace App\Entity\Voucher;

use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Voucher;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Entry extends Voucher
{
    use IdentifiableTrait;
}
