<?php

namespace Tjmpromos\SortableGallery\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection as DBCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Tjmpromos\SortableGallery\Models\GalleryImage;
use Tjmpromos\SortableGallery\Models\GalleryImageCategory;
use Tjmpromos\SortableGallery\Models\GalleryTag;

class SortableGallery extends Component
{
    use WithPagination;

    public array $selectedFilters = [];

    #[Computed]
    public function filters(): DBCollection
    {
        return Cache::remember(md5('tjm_sortable_gallery_filters'), 60, function () {
            return GalleryTag::getTagsWithTypes(GalleryImageCategory::isNotHidden()->pluck('name')->toArray());
        });
    }

    #[Computed]
    public function images(): LengthAwarePaginator|array
    {
        if (count($this->selectedFilters) > 0) {
            return GalleryImage::query()
                ->active()
                ->withSelectedFilters($this->selectedFilters)
                ->orderBy('created_at', 'desc')
                ->paginate(config('sortable-gallery.images_per_page'));
        } else {
            return GalleryImage::query()
                ->active()
                ->orderBy('created_at', 'desc')
                ->paginate(config('sortable-gallery.images_per_page'));
        }

    }

    #[Computed]
    public function filterGroups()
    {
        return GalleryImageCategory::query()
            ->select('name', 'filter_type')
            ->get()
            ->flatMap(function ($item) {
                return [$item->name => $item->filter_type];
            })->toArray();
    }

    public function updatingSelectedFilters(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset('selectedFilters');
        $this->resetPage();
    }

    public function removeFilter($filterTag): void
    {
        $this->selectedFilters = array_diff($this->selectedFilters, [$filterTag]);
        $this->resetPage();
    }

    public function render(): View|Factory|Application
    {
        return view('sortable-gallery::livewire.sortable-gallery');
    }
}
