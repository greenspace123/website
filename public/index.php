<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Для Vercel - создаём временные директории до загрузки Laravel
if (getenv('APP_ENV') === 'production' || getenv('VERCEL') === '1') {
    $tmpDir = '/tmp/laravel';
    $bootstrapCacheDir = $tmpDir . '/bootstrap/cache';
    
    // Создаём директории
    $dirs = [
        $bootstrapCacheDir,
        $tmpDir . '/storage/framework/cache',
        $tmpDir . '/storage/framework/sessions',
        $tmpDir . '/storage/framework/views',
        $tmpDir . '/logs',
    ];
    
    foreach ($dirs as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
    }
    
    // Переопределяем путь к bootstrap cache
    $bootstrapCachePath = $bootstrapCacheDir;
}

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| If the application is in maintenance / demo mode via the "down" command
| we will load this file so that any pre-rendered content can be shown
| instead of starting the framework, which could cause an exception.
|
*/

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

// Для Vercel - переопределяем пути после создания приложения
if (isset($bootstrapCachePath) && isset($app)) {
    $app->useBootstrapPath($bootstrapCachePath);
    $app->useStoragePath('/tmp/laravel/storage');
}

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
