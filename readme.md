# Content/View loader for Laravel with Livewire

[![Latest Stable Version](https://poser.pugx.org/linuxstreet/wire-content-loader/v/stable)](https://packagist.org/packages/linuxstreet/wire-content-loader)
[![License](https://poser.pugx.org/linuxstreet/wire-content-loader/license)](https://packagist.org/packages/linuxstreet/wire-content-loader)
[![Total Downloads](https://poser.pugx.org/linuxstreet/wire-content-loader/downloads)](https://packagist.org/packages/linuxstreet/wire-content-loader)

## Installation
> **Requires:**
- **[PHP version 8.1 or later](https://php.net/releases/)**
- **[Laravel version 10 or later](https://github.com/laravel/laravel)**
- **[Livewire version 3 or later](https://github.com/livewire/livewire)**
- **[AlpineJS](https://github.com/alpinejs/alpine)**

Via Composer:

```shell
composer require linuxstreet/wire-content-loader
```

## Usage
Seamlessly integrate dynamic content into any part of your web page.
By specifying a unique ID for each loader, you can ensure accurate and independent loading of content within multiple containers.
This feature is particularly valuable for Single-Page Applications (SPAs) or when you need to dynamically load components for a more interactive user experience.

```bladehtml
- Place content loader with default ID
<livewire:content-loader/>

- Set ID to 'menu'
<livewire:content-loader id="menu"/>

- Set ID to 'sidebar' and initially load Blade view into it.
<livewire:content-loader id="sidebar" view="my-blade-view"/>

- Set ID to 'footer' and initially load Livewire component into it.
<livewire:content-loader id="footer" component="my-livewire-component"/>
```
Content loader is listening for 'content-load' browser event. 

AlpineJS @click example:
```html
<button x-data @click.throttle="$dispatch('content-load', [=PARAMS])">Show</button>
```
### Params:

> **Mandatory:**
- **component:** [string] - Name of the Livewire component to be loaded
- OR
- **view:** [string] - Name of the Blade view to be loaded

#### NOTE: _If neither component or view is provided, Exception will be thrown._

> **Optional:**
- **forceReload:** [true|false] - Use only when loading Livewire component. Forces component to re-render if called multiple times. (default: false)
- **spinner:** [true|false] - Enable/Disable loading spinner inside the loader while content is loading. (default: true)
- **spinnerClass:** [string] - Pass additional CSS classes to the loading spinner  (default: '')
- **target:** [string] - Use only if multiple content loaders present on page. (default: 'main')
- **hideWhileLoading:** [true|false] - Show/hide content while re-loading the component.(default: false)
- **params:** [array] - Pass additional params to Component/View (default: [])

## Examples:
Provide either 'component' or 'view' options like this:

```html
{ component: 'livewire_component' }
{ view: 'blade_view' }
```

Sere are some examples with optional params:

```html
{ component: 'my-component', forceReload: true }
{ component: 'my-component', forceReload: true, hideWhileLoading: false }
{ component: 'my-component', forceReload: false, target: 'sidebar }
{ view: 'my-view', target: 'footer, spinner: false }
{ view: 'my-view', target: 'footer, spinner: false, params: { id: 5 } }
```

Examples with HTML button element using AlpineJS:

```html
<button x-data @click.throttle="$dispatch('content-load', [{ component: 'my-component', forceReload: true }] )">Show</button>
<button x-data @click.throttle="$dispatch('content-load', [{ component: 'my-component', forceReload: true, hideWhileLoading: false }] )">Show</button>
<button x-data @click.throttle="$dispatch('content-load', [{ component: 'my-component', forceReload: true, params: { id: 1 } }] )">Show</button>
```

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Layout Customisation
This package uses [TailwindCSS](https://github.com/tailwindlabs/tailwindcss) classes. If you want to customize the layout for different CSS framework use:

```shell
php artisan vendor:publish --provider="Linuxstreet\WireContentLoader\WireContentLoaderServiceProvider"
```

## Testing

```shell
./vendor/bin/pest
```

## Contributing

Please see [contributing.md](contributing.md) for details.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- Igor Jovanovic

## License

Please see the [license file](license.md) for more information.