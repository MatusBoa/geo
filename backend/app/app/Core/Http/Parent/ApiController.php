<?php

declare(strict_types=1);

namespace App\Core\Http\Parent;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use App\Core\Database\Parent\Model;
use Brick\Math\Exception\MathException;
use Illuminate\Database\Eloquent\Builder;
use App\Core\Http\Data\Transporter\PaginationBehavior;

abstract class ApiController extends Controller
{
    /**
     * @template T of \App\Core\Database\Parent\Model
     *
     * @param class-string<\App\Core\Http\Contract\ApiTransformerInterface<T>> $transformer
     * @param \Illuminate\Database\Eloquent\Builder<T> $query
     * @param null|\App\Core\Http\Data\Transporter\PaginationBehavior $paginationBehavior
     *
     * @return \App\Core\Http\Parent\StreamedApiResponse
     */
    protected function queryResponse(
        string $transformer,
        Builder $query,
        ?PaginationBehavior $paginationBehavior = null,
    ): StreamedApiResponse {
        // @todo: This helper method may by refactored using some kind of custom ServiceContainer
        $transformerInstance = \resolve($transformer);

        if ($paginationBehavior === null) {
            return new StreamedApiResponse([
                'items' => $transformerInstance->transformIterable(
                    $query->getEagerLoads() === [] ? $query->cursor() : $query->lazy(200),
                ),
            ]);
        }

        $totalCount = $query->withoutEagerLoads()->count();

        $query
            ->limit($paginationBehavior->getPerPage())
            ->offset((\max(0, $paginationBehavior->getCurrentPage()) - 1) * $paginationBehavior->getPerPage());

        try {
            $totalPages = BigDecimal::of($totalCount)
                ->dividedBy($paginationBehavior->getPerPage(), roundingMode: RoundingMode::UP)
                ->toInt();
        } catch (MathException) {
            $totalPages = -1;
        }

        return new StreamedApiResponse([
            'items' => $transformerInstance->transformIterable($query->get()),
            '_pagination' => [
                'page' => $paginationBehavior->getCurrentPage(),
                'per_page' => $paginationBehavior->getPerPage(),
                'total_count' => $totalCount,
                'total_pages' => $totalPages,
            ],
        ]);
    }

    /**
     * @template T of \App\Core\Database\Parent\Model
     *
     * @param class-string<\App\Core\Http\Contract\ApiTransformerInterface<T>> $transformer
     * @param T $model
     *
     * @return \App\Core\Http\Parent\ApiResponse
     */
    protected function modelResponse(
        string $transformer,
        Model $model,
    ): ApiResponse {
        // @todo: This helper method may by refactored using some kind of custom ServiceContainer
        $transformerInstance = \resolve($transformer);

        return new ApiResponse(
            $transformerInstance->transform($model),
        );
    }

    /**
     * @return \App\Core\Http\Parent\ApiResponse
     */
    protected function emptyResponse(): ApiResponse
    {
        return new ApiResponse(status: 204);
    }
}
