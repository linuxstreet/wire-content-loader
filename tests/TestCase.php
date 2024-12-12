<?php

namespace Tests;

use Illuminate\Support\Facades\Artisan;
use Linuxstreet\WireContentLoader\WireContentLoaderServiceProvider;
use Livewire\LivewireServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    private function makeACleanSlate(): void
    {
        Artisan::call('view:clear');
    }

    protected function setUp(): void
    {
        $this->afterApplicationCreated(function () {
            $this->makeACleanSlate();
        });

        $this->beforeApplicationDestroyed(function () {
            $this->makeACleanSlate();
        });

        parent::setUp();
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('view.paths', [
            __DIR__.'/views',
            resource_path('views'),
        ]);

        $app['config']->set('app.key', 'base64:RbD0imxLjBdFL6dpJIoQXW+c1I4ZJj+J8NsGxLd+slw=');
    }

    protected function getPackageProviders($app): array
    {
        return [
            LivewireServiceProvider::class,
            WireContentLoaderServiceProvider::class,
        ];
    }
}
