<?php

namespace Tjmpromos\SortableGallery;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Tjmpromos\SortableGallery\Filament\Resources\GalleryImageResource;

class FilamentSortableGalleryServiceProvider extends PluginServiceProvider
{

    protected array $resources = [
        GalleryImageResource::class,
    ];


    public function configurePackage(Package $package): void
    {
        $package->name('Sortable Gallery');
    }

}
