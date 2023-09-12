<?php

namespace Tjmpromos\SortableGallery\Filament\Resources\GalleryImageResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Tjmpromos\SortableGallery\Filament\Resources\GalleryImageResource;

class EditGalleryImage extends EditRecord
{
    protected static string $resource = GalleryImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
