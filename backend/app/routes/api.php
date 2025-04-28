<?php

declare(strict_types=1);

\Illuminate\Support\Facades\Route::apiResource(
    'products',
    \App\Container\Product\UI\Api\V1\Controller\ProductApiController::class,
);
