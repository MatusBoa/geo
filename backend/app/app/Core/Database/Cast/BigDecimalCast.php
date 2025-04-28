<?php

declare(strict_types=1);

namespace App\Core\Database\Cast;

use Brick\Math\BigDecimal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

/**
 * @implements \Illuminate\Contracts\Database\Eloquent\CastsAttributes<null|\Brick\Math\BigDecimal, null|float>
 */
final class BigDecimalCast implements CastsAttributes
{
    /**
     * @inheritDoc
     */
    public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value === null) {
            return null;
        }

        return BigDecimal::of($value);
    }

    /**
     * @inheritDoc
     */
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value instanceof BigDecimal) {
            return $value->toFloat();
        }

        return $value;
    }
}
