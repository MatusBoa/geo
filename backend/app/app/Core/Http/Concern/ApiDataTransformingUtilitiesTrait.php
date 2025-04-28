<?php

declare(strict_types=1);

namespace App\Core\Http\Concern;

use Brick\Math\BigDecimal;
use Illuminate\Support\Number;

trait ApiDataTransformingUtilitiesTrait
{
    /**
     * @param null|\DateTimeInterface $date
     *
     * @return ($date is null ? null : string)
     */
    protected function formatDateTime(?\DateTimeInterface $date): ?string
    {
        return $date?->format('Y-m-d H:i:s');
    }

    /**
     * @param null|\Brick\Math\BigDecimal $bigDecimal
     * @param positive-int $scale
     *
     * @return ($bigDecimal is null ? null : array{'raw': float, 'formatted': string})
     *
     * @throws \Brick\Math\Exception\RoundingNecessaryException
     */
    protected function formatBigDecimal(
        ?BigDecimal $bigDecimal,
        int $scale = 2,
    ): ?array {
        if ($bigDecimal === null) {
            return null;
        }

        $bigDecimal = $bigDecimal->toScale($scale);

        $formatted = Number::currency(
            $bigDecimal->toFloat(),
            'CZK', // @todo: Should be dynamic
            'ces',
        );

        return [
            'raw' => $bigDecimal->toFloat(),
            'formatted' => $formatted !== false ? $formatted : (string) $bigDecimal->toFloat(),
        ];
    }
}
