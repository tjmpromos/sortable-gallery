<?php

namespace Tjmpromos\SortableGallery\Http\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection as DBCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;
use Tjmpromos\SortableGallery\Models\GalleryImage;
use Tjmpromos\SortableGallery\Models\GalleryTag;

class SortableGallery extends Component
{
    use WithPagination;

    public $selectedFilters = [];

    public $imageIds = []; // array of image ids used to target watcher for resetting BaguetteBox

    public function getGalleryIdAttribute(): string
    {
        return 'gallery_'.$this->id;
    }

    public function getFiltersProperty(): DBCollection
    {
        return Cache::remember(md5('tjm_sortable_gallery_filters'), 60, function () {
            return GalleryTag::getTagsWithTypes(config('sortable-gallery.tag_types'));
        });
    }

    public function queryGalleryImages(): LengthAwarePaginator|array
    {
        if (count($this->selectedFilters) > 0) {
            $images = GalleryImage::query()
                ->active()
                ->withSelectedFilters($this->selectedFilters)
                ->orderBy('created_at', 'desc')
                ->paginate(config('website.misc.gallery_pagination'));
        } else {
            $images = GalleryImage::query()
                ->active()
                ->orderBy('created_at', 'desc')
                ->paginate(config('website.misc.gallery_pagination'));
        }

        // set image ids for alpinejs watcher
        $this->imageIds = $images->pluck('id')->map(function ($id) {
            return 'gallery_'.$id;
        });

        return $images;
    }

    public function updatingSelectedFilters()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset('selectedFilters');
        $this->resetPage();
    }

    public function removeFilter($filterTag)
    {
        $this->selectedFilters = array_diff($this->selectedFilters, [$filterTag]);
        $this->resetPage();
    }

    public function render(): View|Factory|Application
    {
        return view('sortable-gallery::livewire.sortable-gallery', [
            'galleryImages' => $this->queryGalleryImages(),
        ]);
    }
}
