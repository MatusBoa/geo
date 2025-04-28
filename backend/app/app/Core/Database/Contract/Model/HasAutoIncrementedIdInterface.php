<?php

declare(strict_types=1);

namespace App\Core\Database\Contract\Model;

interface HasAutoIncrementedIdInterface
{
    public const ATTR_ID = 'id';

    /**
     * @return positive-int
     */
    public function getId(): int;
}
