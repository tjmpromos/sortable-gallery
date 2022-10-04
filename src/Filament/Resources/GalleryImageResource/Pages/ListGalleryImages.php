<?php

namespace Tjmpromos\SortableGallery\Filament\Resources\GalleryImageResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Tjmpromos\SortableGallery\Filament\Resources\GalleryImageResource;

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
