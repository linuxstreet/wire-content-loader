<?php

use Linuxstreet\WireContentLoader\WireContentLoader;
use function Pest\Livewire\livewire;

it('is initialized', function () {
    livewire(WireContentLoader::class)
        ->assertViewIs('wire-content-loader::livewire.content-loader')
        ->assertSet('params', [])
        ->assertSet('id', 'main')
        ->assertSet('isLoading', false)
        ->assertOk();
});

it('throws exception when component or view is missing', function () {
    livewire(WireContentLoader::class)
        ->call('prepare', []);
})->throws(Exception::class, 'Component or View name must be provided.');

it('sets the component to be loaded', function () {
    livewire(WireContentLoader::class)
        ->call('prepare', ['component' => 'test'])
        ->assertSet('component', 'test');
});

it('sets the view to be loaded', function () {
    livewire(WireContentLoader::class)
        ->call('prepare', ['view' => 'test'])
        ->assertSet('view', 'test')
        ->assertSet('component', null);
});

it('sets the view to be loaded with additional params', function () {
    $p = ['id' => 1, 'options' => ['bulk' => true]];
    livewire(WireContentLoader::class)
        ->call('prepare', ['view' => 'test', 'params' => $p])
        ->assertSet('view', 'test')
        ->assertSet('component', null)
        ->assertSet('params', $p)
        ->assertSee('View [test] not found.');
});

it('render only on the same component id', function () {
    livewire(WireContentLoader::class, ['id' => 'footer'])
        ->assertSet('content', null)
        ->call('prepare', ['component' => 'test', 'target' => 'footer'])
        ->assertSet('content', 'Unable to find component: [test]')
        ->assertSet('component', 'test')
        ->assertSet('isLoading', false)
        ->assertSee('Unable to find component: [test]');
});

it('does not render on different component id', function () {
    livewire(WireContentLoader::class, ['id' => 'main'])
        ->call('prepare', ['component' => 'test', 'target' => 'footer'])
        ->assertSet('content', null)
        ->assertSet('component', null)
        ->assertSet('isLoading', false)
        ->assertSee(null);
});
