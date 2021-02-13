<?php

namespace App\Providers;

use App\Services\GithuhServices\Concretes\SearchService;
use App\Services\GithuhServices\Contracts\SearchServiceInterface;
use Illuminate\Support\ServiceProvider;

class DependenciesServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SearchServiceInterface::class, SearchService::class);
    }

}
