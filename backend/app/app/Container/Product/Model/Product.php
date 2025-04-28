<?php

declare(strict_types=1);

namespace App\Container\Product\Model;

use Brick\Math\BigDecimal;
use App\Core\Database\Parent\Model;
use Database\Factories\ProductFactory;
use App\Core\Database\Cast\BigDecimalCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Core\Database\Concern\Model\HasTimestampsTrait;
use App\Core\Database\Contract\Model\HasTimestampsInterface;
use App\Core\Database\Concern\Model\HasAutoIncrementedIdTrait;
use App\Core\Database\Contract\Model\HasAutoIncrementedIdInterface;

final class Product extends Model implements HasAutoIncrementedIdInterface, HasTimestampsInterface
{
    use HasAutoIncrementedIdTrait;
    use HasTimestampsTrait;
    /** @use \Illuminate\Database\Eloquent\Factories\HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    public const string ATTR_NAME = 'name';
    public const string ATTR_PRICE = 'price';

    /**
     * @inheritDoc
     */
    protected $fillable = [
        self::ATTR_NAME,
        self::ATTR_PRICE,
    ];

    /**
     * @inheritDoc
     */
    protected function casts(): array
    {
        return [
            self::ATTR_NAME => 'string',
            self::ATTR_PRICE => BigDecimalCast::class,
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getAttributeValue(self::ATTR_NAME);
    }

    /**
     * @return \Brick\Math\BigDecimal
     */
    public function getPrice(): BigDecimal
    {
        return $this->getAttributeValue(self::ATTR_PRICE);
    }

    /**
     * @return \Database\Factories\ProductFactory
     */
    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }
}
