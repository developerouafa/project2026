<?php

namespace App\Providers;

use App\Interfaces\Dashboard_Users\sections\childrenRepositoryInterface;
use App\Interfaces\Dashboard_Users\sections\SectionRepositoryInterface;
use App\Repository\Dashboard_Users\sections\childrenRepository;
use App\Repository\Dashboard_Users\sections\SectionRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SectionRepositoryInterface::class, SectionRepository::class);
        $this->app->bind(childrenRepositoryInterface::class, childrenRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
