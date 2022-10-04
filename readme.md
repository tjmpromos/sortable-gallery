# Sortable Gallery

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

This is a quickly installable, sortable gallery for Laravel applications. Under the hood, it utilizes [Filament](https://filamentphp.com/docs/2.x/) for managing assets. We default to using [Livewire](https://laravel-livewire.com/docs/2.x/quickstart) and [Alpine.js](https://alpinejs.dev/start-here) for interactions and [TailwindCSS](https://tailwindcss.com/docs/installation) for styling, but you are welcome to publish the views and change the front end to whatever you desire.

## Installation

Via Composer

``` bash
composer require tjmpromos/sortable-gallery
```

## Getting Started

If you aren't currently using Filament, you'll need to run a few commands to get started. We recommend checking out [Filament's documentation](https://filamentphp.com/docs/2.x/admin/installation) for installation instructions, but here are the basics just to get you started quickly.

Each time you upgrade Filament, you need to run the filament:upgrade command. We recommend adding this to your composer.json's post-update-cmd:

```
"post-update-cmd": [
    // ...
    "@php artisan filament:upgrade"
],
```

If you don't have one, you may create a new user account using:

``` bash
php artisan make:filament-user
```

Now, you can visit your admin panel at /admin to sign in with the credentials you just created.

Once you are logged in, you will see Gallery Images on the left hand side and you can begin adding images.

### Installing TailwindCSS

This option is not entirely necessary, but if you wish to use our default styling, you'll need to have TailwindCSS installed in your project. You are more than welcome to [publish the livewire component](#publishing-and-editing-the-livewire-component) and roll your own styling.

We highly recommend following the appropriate [installation instructions](https://tailwindcss.com/docs/installation) from the documentation on TailwindCSS website if you decide to utilize our default styling.

### Publishing and Editing The Config File

But first things first! You should probably publish the config file so that you can create your categories. You can do that by running:

``` bash
php artisan vendor:publish --tag=sortable-gallery.config
```

This will create `config/sortable-gallery.php` which will give you a few options such as where you store media, your tag types and the size of your preview images.

`media_library`

This can be local storage or any other media disk you are using in your application such as S3.

`tag_types`

This can be any number of tag types (think of them like categories) that you wish to group your tags into. We utilize them for things like colors, product options, etc...

`preview_image_size`

This allows you to set the image preview size for displaying on the front end.

### Publishing and Editing the Livewire Component

``` bash
php artisan vendor:publish --tag=sortable-gallery.views
```

We've tried to make the UI as standard and non-intrusive as possible, but you'll likely want to make some edits to the styling. This command will publish the livewire component into `resources/vendor/sortable-gallery/livewire` in your project.

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email mikewall@tjmpromos.com instead of using the issue tracker.

## Credits

- [Mike Wall](https://github.com/daikazu)
- [Cory Dymond](https://github.com/dymond)
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/tjmpromos/sortable-gallery.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/tjmpromos/sortable-gallery.svg?style=flat-square


[link-packagist]: https://packagist.org/packages/tjmpromos/sortable-gallery
[link-downloads]: https://packagist.org/packages/tjmpromos/sortable-gallery
[link-author]: https://github.com/tjmpromos
[link-contributors]: ../../contributors
