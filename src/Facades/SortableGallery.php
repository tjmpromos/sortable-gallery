<?php

namespace Tjmpromos\SortableGallery\Facades;

use Illuminate\Support\Facades\Facade;

class SortableGallery extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'sortable-gallery';
    }
}
