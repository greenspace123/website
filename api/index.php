<?php

// Для Vercel - создаём временные директории ДО загрузки Laravel
if (getenv('APP_ENV') === 'production' || getenv('VERCEL') === '1') {
    $tmpDir = '/tmp/laravel';
    
    // Создаём все необходимые директории
    $dirs = [
        $tmpDir . '/bootstrap/cache',
        $tmpDir . '/storage/framework/cache',
        $tmpDir . '/storage/framework/sessions',
        $tmpDir . '/storage/framework/views',
        $tmpDir . '/logs',
        $tmpDir . '/database',
    ];
    
    foreach ($dirs as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
    }
    
    // Переопределяем пути к кэшу через environment variables
    putenv("VIEW_COMPILED_PATH=" . $tmpDir . '/storage/framework/views');
    putenv("CACHE_DRIVER=array");
    putenv("SESSION_DRIVER=cookie");
    putenv("LOG_CHANNEL=errorlog");
}

// Подключаем Laravel
require __DIR__.'/../public/index.php';
