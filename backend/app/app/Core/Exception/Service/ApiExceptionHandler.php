<?php

declare(strict_types=1);

namespace App\Core\Exception\Service;

use App\Core\Http\Parent\ApiResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final readonly class ApiExceptionHandler
{
    /**
     * @param \Illuminate\Foundation\Configuration\Exceptions $exceptions
     */
    public function __construct(
        private Exceptions $exceptions,
    ) {
    }

    public function handle(): void
    {
        $this->exceptions->renderable(
            static fn (NotFoundHttpException $exception): ApiResponse => new ApiResponse(
                ['message' => $exception->getMessage()],
                404,
            ),
        );

        $this->exceptions->renderable(
            static fn (ValidationException $exception): ApiResponse => new ApiResponse(
                [
                    'message' => $exception->getMessage(),
                    'fields' => $exception->errors(),
                ],
                422,
            ),
        );

        $this->exceptions->renderable(
            static fn (\Throwable $exception): ApiResponse => new ApiResponse(
                ['message' => $exception->getMessage()],
                500,
            ),
        );
    }
}
