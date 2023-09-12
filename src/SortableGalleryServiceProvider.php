<?php

namespace Tjmpromos\SortableGallery;

use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Tjmpromos\SortableGallery\Livewire\SortableGallery;

class SortableGalleryServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('sortable-gallery')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigrations(['create_gallery_images_table', 'create_gallery_image_categories_table']);
    }

    public function packageBooted(): void
    {
        Livewire::component('sortable-gallery', SortableGallery::class);
    }
}
