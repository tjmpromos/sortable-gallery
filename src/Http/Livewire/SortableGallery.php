<?php

namespace Tjmpromos\SortableGallery\Http\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Tags\Tag;
use Tjmpromos\SortableGallery\Models\GalleryImage;

class SortableGallery extends Component
{
    use WithPagination;

    public $filters = [];

    public $imageIds = []; // array of image ids used to target watcher for resetting BaguetteBox

    public function getGalleryIdAttribute()
    {
        return 'gallery_' . $this->id;
    }

    public function getFilterTypesProperty()
    {
        return Cache::remember(md5('tjm_sortable_gallery_image_tags'), 60, function () {
            $tagTypes = collect(config('sortable-gallery.tag_types'))->transform(function ($item, $key) {
                return Str::snake($item);
            });
            return $tagTypes
                ->mapWithKeys(fn ($tagType) => [$tagType => Tag::getWithType($tagType)->pluck('name', 'id')->sort()])
                ->filter(fn ($val) => $val->count() > 0)
                ->all();
        });
    }

    public function queryGalleryImages(): LengthAwarePaginator|array
    {
        $filterss = $this->filters;
        $filterss = collect($filterss)->transform(function ($item, $key) {
            $tagType = Str::before($item, '|||');
            $actualTag = Str::after($item, '|||');
            return [$tagType => $actualTag];
        });
//        $this->filters = $filterss->toArray();
        ray($filterss->toArray());
        if (count($this->filters) > 0) {
            $images = GalleryImage::active()
                ->withAnyTags($this->filters)
                ->orderBy('created_at', 'desc')
                ->paginate(config('website.misc.gallery_pagination'));
        } else {
            $images = GalleryImage::active()
                ->orderBy('created_at', 'desc')
                ->paginate(config('website.misc.gallery_pagination'));
        }

//        $this->imageIds = $images->pluck('gallery_id','id')->toArray();
        $this->imageIds = collect();
        $images->each(function ($item, $key) {
            $this->imageIds->push('gallery_' . $item->id);
        });

        return $images;
    }

    public function updatingFilters()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset('filters');
        $this->resetPage();
    }

    public function removeFilter($filterTag)
    {
        $this->filters = array_diff($this->filters, [$filterTag]);
        $this->resetPage();
    }

    /**
     * @return View|Factory|Application
     */
    public function render(): View|Factory|Application
    {
        return view('sortable-gallery::livewire.sortable-gallery', [
            'galleryImages' => $this->queryGalleryImages(),
        ]);
    }
}
