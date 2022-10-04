<?php

namespace Tjmpromos\SortableGallery\Filament\Resources\GalleryImageResource\Pages;

use Tjmpromos\SortableGallery\Filament\Resources\GalleryImageResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGalleryImages extends ListRecords
{
    protected static string $resource = GalleryImageResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
