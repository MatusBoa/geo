<?php

declare(strict_types=1);

namespace App\Core\Http\Contract;

/**
 * @template T
 */
interface ApiTransformerInterface
{
    /**
     * @param T $item
     *
     * @return array<non-empty-string, mixed>
     */
    public function transform(mixed $item): array;

    /**
     * @param iterable<array-key, T> $iterable
     *
     * @return iterable<array-key, array<non-empty-string, mixed>>
     */
    public function transformIterable(iterable $iterable): iterable;
}
