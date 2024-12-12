<?php

namespace Linuxstreet\WireContentLoader;

use Livewire\Livewire;

class WireContentLoaderServiceProvider extends \Illuminate\Support\ServiceProvider
{
    private function bootResources(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'wire-content-loader');
    }

    private function bootLivewireComponents(): void
    {
        if (! class_exists(Livewire::class)) {
            return;
        }

        Livewire::component('content-loader', WireContentLoader::class);
    }

    private function bootForConsole(): void
    {
        $this->publishes([
            __DIR__.'/../resources/views' => $this->app->resourcePath('views/vendor/wire-content-loader'),
        ], 'wire-content-loader');
    }

    public function boot(): void
    {
        $this->bootResources();
        $this->bootLivewireComponents();

        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }
}
