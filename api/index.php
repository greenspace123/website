<?php

// Для Vercel - используем временные директории для кэша
if (getenv('APP_ENV') === 'production' || getenv('VERCEL') === '1') {
    // Создаём временные директории
    $tmpDir = '/tmp/laravel';
    $cacheDir = $tmpDir . '/bootstrap/cache';
    $viewDir = $tmpDir . '/framework/views';
    $configDir = $tmpDir . '/framework/config';
    $logDir = $tmpDir . '/logs';
    
    // Создаём все необходимые директории
    $dirs = [
        $tmpDir,
        $cacheDir,
        $viewDir,
        $configDir,
        $logDir,
        $tmpDir . '/storage/framework/cache',
        $tmpDir . '/storage/framework/sessions',
        $tmpDir . '/storage/framework/views',
    ];
    
    foreach ($dirs as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
    }
    
    // Переопределяем пути к кэшу через environment variables
    putenv("VIEW_COMPILED_PATH=$viewDir");
    putenv("CACHE_DRIVER=array");
    putenv("SESSION_DRIVER=cookie");
    putenv("LOG_CHANNEL=errorlog");
}

// Подключаем Laravel
require __DIR__.'/../public/index.php';
