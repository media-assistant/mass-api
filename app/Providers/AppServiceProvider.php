<?php

namespace App\Providers;

use App\Models\Request\Request;
use App\Observers\RequestObserver;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();

        $this->bootObservers();
    }

    private function bootObservers(): void
    {
        Request::observe(RequestObserver::class);
    }
}
