<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        $this->app->bind('settings', function () {
            return Cache::store(config('cache.default'))->rememberForever('settings', function () {
                return Setting::select('key', 'value')
                    ->get()
                    ->mapWithKeys(function ($i) {
                        return [$i->key => $i->value];
                    })
                    ->toArray();
            });
        });
    }
}
