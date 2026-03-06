<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class VercelCacheServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Настраиваем кэш на использование array драйвера в production
        if ($this->app->environment('production')) {
            config(['cache.default' => 'array']);
            config(['cache.stores.array' => ['driver' => 'array', 'serialize' => false]]);
            
            // Отключаем кэширование конфига и маршрутов
            config(['app.compile' => false]);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // В production не используем кэшированные конфиги и маршруты
        if ($this->app->environment('production')) {
            // Принудительно отключаем кэширование
            $this->app->useCompiledPath(function () {
                return '/tmp';
            });
        }
    }
}
