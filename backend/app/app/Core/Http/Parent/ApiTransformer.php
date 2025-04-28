<?php

declare(strict_types=1);

namespace App\Core\Http\Parent;

use App\Core\Http\Contract\ApiTransformerInterface;

/**
 * @template T
 *
 * @implements \App\Core\Http\Contract\ApiTransformerInterface<T>
 */
abstract class ApiTransformer implements ApiTransformerInterface
{
    /**
     * @inheritDoc
     */
    public function transformIterable(iterable $iterable): iterable
    {
        foreach ($iterable as $item) {
            yield $this->transform($item);
        }
    }
}
