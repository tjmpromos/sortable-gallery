<?php

namespace Tjmpromos\SortableGallery\Filament\Resources;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Tjmpromos\SortableGallery\Filament\Resources\GalleryImageCategoryResource\Pages;
use Tjmpromos\SortableGallery\Models\GalleryImageCategory;
use Tjmpromos\SortableGallery\Models\GalleryTag;

class GalleryImageCategoryResource extends Resource
{
    protected static ?string $model = GalleryImageCategory::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Filter Groups';

    protected static ?string $label = 'Filter Group';

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
                                Select::make('filter_type')
                                    ->options([
                                        'multiple' => 'Multiple',
                                        'single' => 'Singular',
                                    ])
                                    ->default('multiple')
                                    ->required(),
                                Toggle::make('is_hidden')
                                    ->label('Hide this filter group from the front end?'),
                            ])
                            ->columnSpan(1),

                    ]),

            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function (GalleryImageCategory $record) {
                        // Delete all GalleryTag Tags by type
                        GalleryTag::query()
                            ->where('type', $record->name)
                            ->delete();
                    }),
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
            'index' => Pages\ListGalleryImageCategories::route('/'),
            'create' => Pages\CreateGalleryImageCategory::route('/create'),
            'edit' => Pages\EditGalleryImageCategory::route('/{record}/edit'),
        ];
    }
}
