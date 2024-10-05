<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use \Illuminate\Support\Facades\Vite;

class ViteProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Image macro usage : "Vite::Image('path')"
        Vite::macro('Image', fn ($asset) => $this->asset("resources/images/{$asset}"));

        // Match the vite.config.js
        Vite::useBuildDirectory('') // Customize the build directory...
            ->useManifestFilename('vite-manifest.json'); // Customize the manifest filename...
    }
}
