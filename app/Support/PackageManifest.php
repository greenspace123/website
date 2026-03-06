<?php

namespace App\Support;

use Illuminate\Foundation\PackageManifest as BasePackageManifest;

class PackageManifest extends BasePackageManifest
{
    /**
     * Get the path to the cached package manifest file.
     *
     * @return string
     */
    protected function manifestPath()
    {
        // Используем временную директорию для Vercel
        if (getenv('APP_ENV') === 'production' || getenv('VERCEL') === '1') {
            return '/tmp/laravel/bootstrap/cache/packages.php';
        }
        
        return parent::manifestPath();
    }
}
