<?php

namespace Tjmpromos\SortableGallery\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static pluck(string $string)
 *
 * @property mixed $name
 */
class GalleryImageCategory extends Model
{
    use HasFactory;

    protected $table = 'sortable_gallery_image_categories';
    protected $guarded = ['id'];

    protected $casts = [
        'is_hidden' => 'boolean',
    ];

    public function scopeIsHidden(Builder $query): void
    {
        $query->where('is_hidden', 1);
    }

    public function scopeIsNotHidden(Builder $query): void
    {
        $query->where('is_hidden', 0);
    }
}
