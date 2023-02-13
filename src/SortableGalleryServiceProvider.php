<?php

namespace Tjmpromos\SortableGallery;

use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Tjmpromos\SortableGallery\Http\Livewire\SortableGallery;

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
            ->hasMigrations(['create_media_table', 'create_tag_tables', 'create_gallery_images_table']);
    }

    public function packageBooted()
    {
        Livewire::component('sortable-gallery', SortableGallery::class);
    }
}
