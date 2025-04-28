<?php

declare(strict_types=1);

namespace App\Container\Product\UI\Api\V1\RequestFilter;

use Illuminate\Http\Request;
use App\Container\Product\Model\Product;
use App\Core\Http\Parent\ApiRequestFilter;
use Illuminate\Contracts\Validation\Factory;

final class ProductApiRequestFilter extends ApiRequestFilter
{
    public const string FIELD_NAME = Product::ATTR_NAME;
    public const string FIELD_PRICE = Product::ATTR_PRICE;

    /**
     * @param \Illuminate\Contracts\Validation\Factory $validatorFactory
     */
    public function __construct(
        private readonly Factory $validatorFactory,
    ) {
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array<self::FIELD_*, mixed>
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getValidatedData(Request $request): array
    {
        $sometimesRequired = $this->getSometimesRequiredRule($request);

        return $this->validatorFactory->make($request->post(), [
            self::FIELD_NAME => [$sometimesRequired, 'string', 'max:255'],
            self::FIELD_PRICE => [$sometimesRequired, 'numeric', 'decimal:0,2'],
        ])->validated();
    }
}
