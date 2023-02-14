<?php

namespace Tjmpromos\SortableGallery\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Tags\HasTags;

class GalleryImage extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasTags;

    protected $guarded = ['id'];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Register the media collections.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('gallery_images')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png']);
    }

    /**
     * Register the media conversions.
     *
     * @param  Media|null  $media
     * @return void
     *
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        // @phpstan-ignore-next-line
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 100, 100)
            ->optimize()
            ->performOnCollections('gallery_images');

        // @phpstan-ignore-next-line
        $this->addMediaConversion('preview')
            ->crop(Manipulations::CROP_CENTER,
                config('sortable-gallery.preview_image_size.width'),
                config('sortable-gallery.preview_image_size.height'))
            ->width(config('sortable-gallery.preview_image_size.width'))
            ->height(config('sortable-gallery.preview_image_size.height'))
            ->optimize()
            ->performOnCollections('gallery_images');
    }

    /**
     * Scope a query to only include active users.
     *
     * @param  Builder  $query
     * @return void
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }

    public function scopeWithSelectedFilters(Builder $query, array $filters): void
    {
        $tagIds = [];

        $tags = collect($filters)
            ->map(function ($value) {
                [$type, $tag] = explode('|', $value);

                return compact('type', 'tag');
            })
            ->groupBy('type')
            ->map->pluck('tag')
            ->each(function ($tagNames, $tagType) use (&$tagIds) {
                $tagIds[$tagType] = static::convertToTags($tagNames, $tagType)
                    ->pluck('id')
                    ->toArray();
            });

        $tagIds = collect($tagIds)->flatten()->toArray();

        $query->whereHas('tags', function (Builder $query) use ($tagIds) {
            $query->whereIn('tags.id', $tagIds);
        });
    }
}
