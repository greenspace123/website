<?php

namespace App\Support;

use Illuminate\Foundation\PackageManifest as BasePackageManifest;

class PackageManifest extends BasePackageManifest
{
    /**
     * The manifest path.
     *
     * @var string
     */
    protected $manifestPath;
    
    /**
     * Create a new package manifest instance.
     *
     * @param  string  $manifestPath
     * @return void
     */
    public function __construct($manifestPath)
    {
        $this->manifestPath = $manifestPath;
    }
    
    /**
     * Get the path to the cached package manifest file.
     *
     * @return string
     */
    protected function manifestPath()
    {
        return $this->manifestPath;
    }
}
