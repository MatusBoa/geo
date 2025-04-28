<?php

declare(strict_types=1);

namespace App\Container\Product\UI\Api\V1\Controller;

use Illuminate\Http\Request;
use App\Core\Http\Parent\ApiResponse;
use App\Core\Http\Parent\ApiController;
use App\Container\Product\Model\Product;
use App\Core\Http\Parent\StreamedApiResponse;
use App\Core\Http\Factory\PaginationBehaviorFactory;
use App\Container\Product\UI\Api\V1\Transformer\ProductApiTransformer;
use App\Container\Product\UI\Api\V1\RequestFilter\ProductApiRequestFilter;

final class ProductApiController extends ApiController
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Core\Http\Factory\PaginationBehaviorFactory $paginationBehaviorFactory
     *
     * @return \App\Core\Http\Parent\StreamedApiResponse
     */
    public function index(
        Request $request,
        PaginationBehaviorFactory $paginationBehaviorFactory
    ): StreamedApiResponse {
        // whole controller may have middleware, that validates JWT or any other kind of authorization

        return $this->queryResponse(
            ProductApiTransformer::class,
            Product::query(),
            $paginationBehaviorFactory->createFromRequest($request)
        );
    }

    /**
     * @param int $id
     *
     * @return \App\Core\Http\Parent\ApiResponse
     */
    public function show(int $id): ApiResponse
    {
        // repository pattern may be used here
        $product = Product::query()->whereKey($id)->sole();

        return $this->modelResponse(
            ProductApiTransformer::class,
            $product,
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Container\Product\UI\Api\V1\RequestFilter\ProductApiRequestFilter $requestFilter
     *
     * @return \App\Core\Http\Parent\ApiResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(
        Request $request,
        ProductApiRequestFilter $requestFilter,
    ): ApiResponse {
        $validated = $requestFilter->getValidatedData($request);

        return $this->modelResponse(
            ProductApiTransformer::class,
            Product::query()->create($validated),
        )->setStatusCode(201);
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @param \App\Container\Product\UI\Api\V1\RequestFilter\ProductApiRequestFilter $requestFilter
     *
     * @return \App\Core\Http\Parent\ApiResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Throwable
     */
    public function update(
        int $id,
        Request $request,
        ProductApiRequestFilter $requestFilter,
    ): ApiResponse {
        $product = Product::query()->whereKey($id)->sole();

        $validated = $requestFilter->getValidatedData($request);

        $product->updateOrFail($validated);

        return $this->modelResponse(
            ProductApiTransformer::class,
            $product,
        );
    }

    /**
     * @param int $id
     *
     * @return \App\Core\Http\Parent\ApiResponse
     *
     * @throws \Throwable
     */
    public function destroy(int $id): ApiResponse
    {
        $product = Product::query()->whereKey($id)->sole();

        $product->deleteOrFail();

        return $this->emptyResponse();
    }
}
