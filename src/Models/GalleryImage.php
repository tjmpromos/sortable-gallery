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

/**
 * @method active()
 * @method notActive()
 *
 * @property mixed $name
 */
class GalleryImage extends Model implements HasMedia
{
    use HasFactory;
    use HasTags;
    use InteractsWithMedia;

    protected $table = 'sortable_gallery_images';

    protected $guarded = ['id'];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Register the media collections.
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
     *
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(?Media $media = null): void
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
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }

    public function scopeNotActive(Builder $query): void
    {
        $query->where('active', 0);
    }

    public function scopeWithSelectedFilters(Builder $query, array $filters): void
    {
        $tagIds = [];

        $test = collect($filters)
            ->map(function ($value) {
                [$type, $tag] = explode('|', $value);

                return compact('type', 'tag');
            });

        $filterGroups = GalleryImageCategory::query()
            ->select('name', 'filter_type')
            ->whereIn('name', $test->pluck('type')->unique())
            ->get()
            ->flatMap(function ($item) {
                return [$item->name => $item->filter_type];
            });

        collect($filters)
            ->map(function ($value) {
                [$type, $tag] = explode('|', $value);

                return compact('type', 'tag');
            })->groupBy('type')
            ->map->pluck('tag')
            ->each(function ($tagNames, $tagType) use (&$tagIds, $filterGroups) {
                $tagIds[$filterGroups[$tagType]] = static::convertToTags($tagNames, $tagType)
                    ->pluck('id')
                    ->toArray();
            });

        if ($tagIds['single'] ?? false) {
            $query->whereHas('tags', function ($query) use ($tagIds) {
                $query->whereIn('tags.id', $tagIds['single'] ?? []);
            }, '>=', count($tagIds['single'] ?? []));
        }
        if ($tagIds['multiple'] ?? false) {
            $query->whereHas('tags', function ($query) use ($tagIds) {
                $query->whereIn('tags.id', $tagIds['multiple'] ?? []);
            });
        }

        $query->get();

    }
}
