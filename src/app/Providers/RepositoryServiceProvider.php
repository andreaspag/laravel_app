<?php

namespace App\Providers;

use App\Repositories\Interfaces\ProductsRepositoryInterface;
use App\Repositories\Interfaces\TagsRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\TagRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ProductsRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(TagsRepositoryInterface::class, TagRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
