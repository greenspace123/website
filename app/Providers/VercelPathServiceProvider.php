<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class VercelPathServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            $tmpDir = '/tmp/laravel';
            
            // Переопределяем пути к кэш-директориям
            $this->app->useStoragePath($tmpDir . '/storage');
            $this->app->useDatabasePath($tmpDir . '/database');
            $this->app->useResourcePath($tmpDir . '/resources');
            
            // Путь к кэшу bootstrap
            $this->app->useBootstrapPath($tmpDir . '/bootstrap');
        }
    }
}
