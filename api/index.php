<?php

// Для Vercel - используем временные директории для кэша
if (getenv('APP_ENV') === 'production') {
    // Создаём временные директории если их нет
    $tmpDir = '/tmp/laravel-cache';
    $cacheDir = $tmpDir . '/cache';
    $viewDir = $tmpDir . '/views';
    $configDir = $tmpDir . '/config';
    
    if (!is_dir($tmpDir)) {
        mkdir($tmpDir, 0777, true);
    }
    if (!is_dir($cacheDir)) {
        mkdir($cacheDir, 0777, true);
    }
    if (!is_dir($viewDir)) {
        mkdir($viewDir, 0777, true);
    }
    if (!is_dir($configDir)) {
        mkdir($configDir, 0777, true);
    }
    
    // Переопределяем пути к кэшу
    putenv("VIEW_COMPILED_PATH=$viewDir");
}

require __DIR__.'/../public/index.php';
