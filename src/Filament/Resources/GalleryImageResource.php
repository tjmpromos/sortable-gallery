<?php

namespace Tjmpromos\SortableGallery\Filament\Resources;

use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Tjmpromos\SortableGallery\Filament\Resources\GalleryImageResource\Pages\CreateGalleryImage;
use Tjmpromos\SortableGallery\Filament\Resources\GalleryImageResource\Pages\EditGalleryImage;
use Tjmpromos\SortableGallery\Filament\Resources\GalleryImageResource\Pages\ListGalleryImages;
use Tjmpromos\SortableGallery\Models\GalleryImage;

class GalleryImageResource extends Resource
{
    protected static ?string $model = GalleryImage::class;

    protected static ?string $navigationIcon = 'heroicon-o-photograph';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(5)
                ->schema([
                    TextInput::make('name')
                        ->autofocus()
                        ->required()
                        ->rules('required', 'max:255')
                        ->columnSpan(4),
                    Toggle::make('is_active')
                        ->default(true)
                        ->columnSpan(1)
                        ->inline(false),
                    SpatieMediaLibraryFileUpload::make('gallery_image')
                        ->disk(config('sortable-gallery.media_library.disk_name'))
                        ->collection('gallery_images')
                        ->visibility('public')
                        ->columnSpan(2),
                    Fieldset::make('Image Tags')
                        ->schema(GalleryImageResource::generateTagForms())
                        ->columnSpan(3),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                BooleanColumn::make('is_active')->grow(false),
                SpatieMediaLibraryImageColumn::make('gallery_image')
                    ->grow(false)
                    ->disk(config('sortable-gallery.media_library.disk_name'))
                    ->collection('gallery_images')
                    ->conversion('thumb'),
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGalleryImages::route('/'),
            'create' => CreateGalleryImage::route('/create'),
            'edit' => EditGalleryImage::route('/{record}/edit'),
        ];
    }

    private static function generateTagForms(): array
    {
        return  array_map(function ($type) {
            return SpatieTagsInput::make($type)
                ->type($type)
                ->placeholder('Enter tags');
        }, config('sortable-gallery.tag_types'));
    }
}
