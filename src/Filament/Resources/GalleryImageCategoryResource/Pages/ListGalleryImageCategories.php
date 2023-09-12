<?php

namespace Tjmpromos\SortableGallery\Filament\Resources\GalleryImageCategoryResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Tjmpromos\SortableGallery\Filament\Resources\GalleryImageCategoryResource;

class ListGalleryImageCategories extends ListRecords
{
    protected static string $resource = GalleryImageCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
