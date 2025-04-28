<?php

declare(strict_types=1);

namespace App\Core\Http\Factory;

use Illuminate\Http\Request;
use App\Core\Http\Data\Transporter\PaginationBehavior;

final class PaginationBehaviorFactory
{
    public const string QUERY_PER_PAGE = 'per_page';
    public const string QUERY_PAGE = 'page';

    public const int DEFAULT_PER_PAGE = 10;
    public const int DEFAULT_STARTING_PAGE = 1;

    public const int MAX_PER_PAGE = 100;

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \App\Core\Http\Data\Transporter\PaginationBehavior
     */
    public function createFromRequest(Request $request): PaginationBehavior
    {
        return new PaginationBehavior(
            \min(
                self::MAX_PER_PAGE,
                \max(1, (int) $request->query(self::QUERY_PER_PAGE, (string) self::DEFAULT_PER_PAGE)),
            ),
            (int) $request->query(self::QUERY_PAGE, (string) self::DEFAULT_STARTING_PAGE),
        );
    }
}
