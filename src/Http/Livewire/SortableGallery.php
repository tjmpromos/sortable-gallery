<?php

namespace Tjmpromos\SortableGallery\Http\Livewire;


use Tjmpromos\SortableGallery\Models\GalleryImage;
use Livewire\Component;
use Livewire\WithPagination;

class SortableGallery extends Component
{
    use WithPagination;

    public $filters = [];

    public $imageIds = []; // array of image ids used to target watcher for resetting BaguetteBox


    public function getFilterTypesProperty()
    {
        return config('sortable-gallery.tag_types');
    }

    public function queryGalleryImages()
    {
        if (count($this->filters) > 0) {
            $images = GalleryImage::active()
                ->withAnyTagsOfAnyType($this->filters)
                ->paginate(config('website.misc.gallery_pagination'));
        } else {
            $images = GalleryImage::active()
                ->paginate(config('website.misc.gallery_pagination'));
        }

        $this->imageIds = $images->pluck('id')->toArray();

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

    public function render()
    {
        return view('sortable-gallery::livewire.sortable-gallery', [
            'galleryImages' => $this->queryGalleryImages(),
        ]);
    }
}
