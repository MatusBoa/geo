<?php

declare(strict_types=1);

namespace App\Core\Application\Provider;

use Carbon\CarbonImmutable;
use Illuminate\Support\DateFactory;
use Illuminate\Support\ServiceProvider;

class ApplicationServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    #[\Override]
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        DateFactory::use(CarbonImmutable::class);
    }
}
