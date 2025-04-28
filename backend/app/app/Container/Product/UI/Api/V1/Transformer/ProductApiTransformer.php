<?php

declare(strict_types=1);

namespace App\Container\Product\UI\Api\V1\Transformer;

use App\Container\Product\Model\Product;
use App\Core\Http\Parent\ApiTransformer;
use App\Core\Http\Concern\ApiDataTransformingUtilitiesTrait;

/**
 * @extends \App\Core\Http\Parent\ApiTransformer<\App\Container\Product\Model\Product>
 */
final class ProductApiTransformer extends ApiTransformer
{
    use ApiDataTransformingUtilitiesTrait;

    public const string PROP_ID = Product::ATTR_ID;
    public const string PROP_NAME = Product::ATTR_NAME;
    public const string PROP_PRICE = Product::ATTR_PRICE;
    public const string PROP_CREATED_AT = Product::ATTR_CREATED_AT;
    public const string PROP_UPDATED_AT = Product::ATTR_UPDATED_AT;

    /**
     * @inheritDoc
     */
    public function transform(mixed $item): array
    {
        return [
            self::PROP_ID => $item->getId(),
            self::PROP_NAME => $item->getName(),
            self::PROP_PRICE => $this->formatBigDecimal($item->getPrice()),
            self::PROP_CREATED_AT => $this->formatDateTime($item->getCreatedAt()),
            self::PROP_UPDATED_AT => $this->formatDateTime($item->getUpdatedAt()),
        ];
    }

    // filtering of results may be here
}
