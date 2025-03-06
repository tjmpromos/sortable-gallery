<?php

namespace Tjmpromos\SortableGallery;

use Filament\Contracts\Plugin;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;

class SortableGalleryPlugin implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }

    public function getId(): string
    {
        return 'sortable-gallery';
    }

    public function register(Panel $panel): void
    {

        $panel->resources([
            Filament\Resources\GalleryImageResource::class,
            Filament\Resources\GalleryImageCategoryResource::class,
        ])->navigationGroups([
            NavigationGroup::make()
                ->label(config('sortable-gallery.navigation_group_label'))
                ->icon('heroicon-o-photo')
                ->collapsed(true),
        ]);

    }

    public function boot(Panel $panel): void {}
}
