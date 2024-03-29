<p align="center">
    <img src="https://repository-images.githubusercontent.com/544939993/705286e7-8d16-493d-b1bb-58d994137556" alt="Sortable Gallery banner" style="width: 100%; max-width: 800px;" />
</p>

# Sortable Gallery for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tjmpromos/sortable-gallery.svg?style=flat-square)](https://packagist.org/packages/tjmpromos/sortable-gallery)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/tjmpromos/sortable-gallery/run-tests.yml?label=tests&style=flat-square)](https://github.com/tjmpromos/sortable-gallery/actions/workflows/run-tests.yml)
[![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/tjmpromos/sortable-gallery/fix-php-code-style-issues.yml?label=code%20style&style=flat-square)](https://github.com/tjmpromos/sortable-gallery/actions/workflows/fix-php-code-style-issues.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/tjmpromos/sortable-gallery.svg?style=flat-square)](https://packagist.org/packages/tjmpromos/sortable-gallery)

This is a quickly installable, sortable gallery for Laravel applications. Under the hood, it utilizes [Filament](https://filamentphp.com/docs/2.x/) for managing assets. We default to using [Livewire](https://laravel-livewire.com/docs/2.x/quickstart) and [Alpine.js](https://alpinejs.dev/start-here) for interactions and [TailwindCSS](https://tailwindcss.com/docs/installation) for styling, but you are welcome to publish the views and change the front end to whatever you desire.

## Prerequisites
Ths package uses the following packages and are required to be installed and configured before installing sortable-gallery:

- [Filament](https://filamentphp.com/docs/2.x/admin/installation)
- [Spatie Media Library](https://docs.spatie.be/laravel-medialibrary/v9/introduction/)
- [Filament Media Library](https://filamentphp.com/docs/2.x/media-library/installation)
- [Spatie Tags](https://docs.spatie.be/laravel-tags/v3/introduction/)
- [Filament Spatie Tags](https://filamentphp.com/docs/2.x/tags/installation)
- [Livewire](https://laravel-livewire.com/docs/2.x/quickstart)

## Optional
These packages are not required, but are used by default for styling and interactions in the view. Feel free to roll your own styling and interactions if you wish.

- [Alpine.js](https://alpinejs.dev/start-here)
- [TailwindCSS](https://tailwindcss.com/docs/installation)

## Installation


Via Composer

``` bash
composer require tjmpromos/sortable-gallery
```

## Getting Started

### New Applications

If you aren't currently using Filament, you'll need to run a few commands to get started. We recommend checking out [Filament's documentation](https://filamentphp.com/docs/2.x/admin/installation) for installation instructions, but here are the basics just to get you started quickly.

You'll need to migrate some tables into your database to get started. To do this, simply run:

``` bash
php artisan migrate
```

### Existing Applications

If you are currently using Filament or have a media table, you may run into conflicts while migrating. To help alleviate this issue, we've provided some publishable migrations. You can export them to your `database/migrations` directory by running:

``` bash
php artisan vendor:publish --tag=sortable-gallery-migrations
```
### Publishing and Editing The Config File

But first things first! You should probably publish the config file so that you can create your categories. You can do that by running:

``` bash
php artisan vendor:publish --tag=sortable-gallery-config
```

This will create `config/sortable-gallery.php` which will give you a few options such as where you store media, your tag types and the size of your preview images.

`media_library`

This can be any number of tag types (think of them like categories) that you wish to group your tags into. We utilize them for things like colors, product options, etc...

`preview_image_size`

This allows you to set the image preview size for displaying on the front end.

## Add to your FilamentPHP v3 admin panel
Add the following to your FilamentPHP AdminPanelProvider.php file or the Panel provider file of your choice:

```php
use Tjmpromos\SortableGallery\SortableGalleryPlugin;

class AdminPanelProvider extends PanelProvider
{
ublic function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
             //... other panel config
             ->plugins([
                SortableGalleryPlugin::make(),
            ]);
    }
}

```

### Publishing and Editing the Livewire Component
We use [BaguetteBox.js](https://feimosi.github.io/baguetteBox.js/) for our lightbox and tried to make the UI as non-intrusive as possible, but you are welcome to use whatever you'd like. You can publish the views and edit the `resources/vendor/sortable-gallery/livewire` view to use whatever you'd like.

``` bash
php artisan vendor:publish --tag=sortable-gallery-views
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Mike Wall](https://github.com/daikazu)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
