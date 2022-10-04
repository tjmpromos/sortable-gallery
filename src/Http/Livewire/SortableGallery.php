<?php

namespace Tjmpromos\SortableGallery\Http\Livewire;


use Illuminate\Support\Facades\Cache;
use Spatie\Tags\Tag;
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
        return Cache::remember(md5(config('website.site_code').'_gallery_image_tags'), 60, function () {
            return collect(config('sortable-gallery.tag_types'))
                ->mapWithKeys(fn($tagType) => [$tagType => Tag::getWithType($tagType)->pluck('name', 'id')->sort()])
                ->filter(fn($val) => $val->count() > 0)
                ->all();
        });
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
