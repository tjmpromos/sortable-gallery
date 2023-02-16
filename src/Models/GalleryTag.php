<?php

namespace Tjmpromos\SortableGallery\Models;

use Illuminate\Database\Eloquent\Collection as DbCollection;
use Spatie\Tags\Tag;

class GalleryTag extends Tag
{
    protected $table = 'tags';

    /**
     * Return a collection of tags grouped by type
     */
    public static function getTagsWithTypes(array $types): DbCollection
    {
        return static::query()
            ->whereIn('type', $types)
            ->get()
            ->groupBy('type');
    }
}
