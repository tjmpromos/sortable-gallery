<?php

namespace Tjmpromos\SortableGallery\Filament\Resources;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\SpatieTagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Tjmpromos\SortableGallery\Filament\Resources\GalleryImageResource\Pages;
use Tjmpromos\SortableGallery\Models\GalleryImage;
use Tjmpromos\SortableGallery\Models\GalleryImageCategory;

class GalleryImageResource extends Resource
{
    protected static ?string $model = GalleryImage::class;
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Images';
    protected static ?string $label = 'Gallery Image';

    public static function getNavigationGroup(): string
    {
        return config('sortable-gallery.navigation_group_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make([
                    'default' => 1,
                    'md' => 2,
                ])
                    ->schema([
                        Section::make()
                            ->schema([
                                TextInput::make('name')
                                    ->autofocus()
                                    ->required()
                                    ->rules('required', 'max:255'),
                                Toggle::make('active')
                                    ->default(true)
                                    ->columnSpan(1)
                                    ->inline(false),
                                SpatieMediaLibraryFileUpload::make('gallery_image')
                                    ->disk(config('sortable-gallery.media_library.disk_name'))
                                    ->collection('gallery_images')
                                    ->visibility('public')
                                    ->conversion('preview')
                                    ->columnSpanfull(),
                            ])
                            ->columnSpan(1),
                        Section::make('Filter Groups')
                            ->schema(self::generateTagForms())
                            ->columnSpan(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ToggleColumn::make('active')->grow(false),
                SpatieMediaLibraryImageColumn::make('gallery_image')
                    ->grow(false)
                    ->disk(config('sortable-gallery.media_library.disk_name'))
                    ->collection('gallery_images')
                    ->conversion('thumb'),
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                SpatieTagsColumn::make('tags')
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListGalleryImages::route('/'),
            'create' => Pages\CreateGalleryImage::route('/create'),
            'edit' => Pages\EditGalleryImage::route('/{record}/edit'),
        ];
    }

    private static function generateTagForms(): array
    {
        return array_map(function ($type) {
            return SpatieTagsInput::make($type)
                ->hint('Hidden')
                ->type($type)
                ->placeholder('Add filter tag');
        }, GalleryImageCategory::pluck('name')->toArray());
    }
}
