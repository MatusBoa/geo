<?php

declare(strict_types=1);

namespace App\Core\Http\Data\Transporter;

final readonly class PaginationBehavior
{
    /**
     * @param int $perPage
     * @param int $currentPage
     */
    public function __construct(
        private int $perPage,
        private int $currentPage,
    ) {
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }
}
