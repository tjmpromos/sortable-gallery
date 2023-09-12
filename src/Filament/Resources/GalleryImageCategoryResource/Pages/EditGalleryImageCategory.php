<?php

namespace Tjmpromos\SortableGallery\Filament\Resources\GalleryImageCategoryResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Tjmpromos\SortableGallery\Filament\Resources\GalleryImageCategoryResource;

class EditGalleryImageCategory extends EditRecord
{
    protected static string $resource = GalleryImageCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
