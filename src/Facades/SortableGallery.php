<?php

namespace Tjmpromos\SortableGallery\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tjmpromos\SortableGallery\SortableGallery
 */
class SortableGallery extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Tjmpromos\SortableGallery\SortableGallery::class;
    }
}
