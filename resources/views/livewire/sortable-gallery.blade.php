<div x-data="{
        menu: false,
        imageIds: @entangle('imageIds'),
        init() {
            $watch('imageIds', () => {
                this.sortableGallery.refresh();
            })
        },
        sortableGallery: lightGallery(document.getElementById('lightGallery'), {
            plugins: [lgThumbnail],
            licenseKey: '0000-0000-000-0000',
            speed: 750,
            download: false
        })
    }"
     x-on:keydown.escape.window="menu = false"
     wire:ignore.self
>
    <div>
        {{-- Mobile filter dialog --}}
        <div x-show="menu" x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0" class="relative z-40 lg:hidden" role="dialog" aria-modal="true">

            <div class="fixed inset-0 bg-black bg-opacity-25"></div>

            <div x-show="menu" x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                 class="fixed inset-0 z-40 flex">

                <div
                    class="relative ml-auto flex h-full w-full max-w-xs flex-col overflow-y-auto bg-white py-4 pb-6 shadow-xl">
                    <div class="flex items-center justify-between px-4">
                        <h2 class="text-lg font-medium text-gray-900">Filters</h2>
                        <button x-on:click="menu = false" type="button"
                                class="-mr-2 flex h-10 w-10 items-center justify-center p-2 text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Close menu</span>
                            {{-- Heroicon name: outline/x-mark --}}
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Filters --}}
                    <form x-data="{ active: 1 }" class="mt-4">
                        @foreach ($this->filters as $key => $filter)
                            <div class="border-t border-gray-200 pt-4 pb-4" x-data="{
                                id: {{ $loop->iteration }},
                                get expanded() {
                                    return this.active === this.id
                                },
                                set expanded(value) {
                                    this.active = value ? this.id : null
                                }
                            }">
                                <fieldset>
                                    <legend class="w-full px-2">
                                        {{-- Expand/collapse section button --}}
                                        <button type="button" x-on:click="expanded = !expanded"
                                                :aria-expanded="expanded"
                                                class="flex w-full items-center justify-between p-2 text-gray-400 hover:text-gray-500"
                                                aria-controls="filter-section-{{ $loop->index }}">
                                            <span
                                                class="text-sm font-semibold text-gray-900">{{ str($key)->title() }}</span>
                                            <span class="ml-6 flex h-7 items-center">
                                                <svg x-bind:class="{ 'rotate-0': expanded, '-rotate-180': !expanded }"
                                                     class="h-5 w-5 rotate-0 transform"
                                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                     fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                          d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                                          clip-rule="evenodd"/>
                                                </svg>
                                            </span>
                                        </button>
                                    </legend>
                                    <div x-show="expanded" x-collapse>
                                        <div class="px-4 pt-4 pb-2" id="filter-section-{{ $loop->index }}">
                                            <div class="space-y-6">
                                                @foreach ($filter as $tag)
                                                    <div class="flex items-center">
                                                        <input
                                                            id="{{ str(implode('-', [$key, $tag->name, $loop->parent->index, 'mobile']))->slug() }}"
                                                            name="filter[]"
                                                            wire:model="selectedFilters"
                                                            value="{{ $key }}|{{ $tag->name }}"
                                                            type="checkbox"
                                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                        >
                                                        <label
                                                            for="{{ str(implode('-', [$key, $tag->name, $loop->parent->index, 'mobile']))->slug() }}"
                                                            class="ml-3 text-sm text-gray-500">{{ $tag->name }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        @endforeach
                    </form>

                    @if (!empty($selectedFilters))
                        <button class="transition-color px-2 py-2 font-semibold hover:bg-red-500 hover:text-white"
                                x-on:click="$wire.clearFilters()">Clear Filters
                        </button>
                    @endif

                </div>
            </div>
        </div>

        <main class="mx-auto max-w-2xl py-12 px-4 sm:px-6 lg:max-w-7xl lg:px-8">

            <div class="pt-12 lg:grid lg:grid-cols-3 lg:gap-x-8 xl:grid-cols-4">
                <aside>
                    <h2 class="sr-only">Filters</h2>

                    <!-- Mobile filter dialog toggle, controls the 'mobileFilterDialogOpen' state. -->
                    <button x-on:click="menu = true" type="button" class="inline-flex items-center lg:hidden">
                        <span class="text-sm font-semibold">Filters</span>
                        <!-- Heroicon name: mini/plus -->
                        <svg class="ml-1 h-5 w-5 flex-shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path
                                d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"/>
                        </svg>
                    </button>


                    <div class="hidden lg:block">

                        <form class="space-y-10 divide-y divide-gray-200">
                            @foreach ($this->filters as $key => $filter)
                                <div @class(['pt-10' => $loop->index > 0])>
                                    <fieldset>
                                        <legend class="w-full px-2 font-semibold">
                                            {{ str($key)->title() }}
                                        </legend>
                                        <div class="space-y-3 pt-6">
                                            @foreach ($filter as $tag)
                                                <div class="flex items-center">
                                                    {{--                                                    @ray(collect(selectedFilters))--}}
                                                    <input
                                                        id="{{ str(implode('-', [$key, $tag->name, $loop->parent->index]))->slug() }}"
                                                        name="filter[]" wire:model="selectedFilters"
                                                        value="{{ $key }}|{{ $tag->name }}"
                                                        type="checkbox"
                                                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                    >
                                                    <label
                                                        for="{{ str(implode('-', [$key, $tag->name, $loop->parent->index]))->slug() }}"
                                                        class="ml-3 text-sm text-gray-600 cursor-pointer">{{ $tag->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </fieldset>
                                </div>
                            @endforeach
                        </form>
                    </div>

                </aside>

                {{-- Image grid --}}
                <div class="mt-6 lg:col-span-2 lg:mt-0 xl:col-span-3">

                    <div class="rounded-lg border-4 border-dashed border-gray-200 bg-white lg:h-full">

                        <div class="">
                            <div class="mx-auto max-w-2xl px-4 lg:max-w-7xl">

                                <div class="min-h-12 flex justify-end">
                                    @if (count($selectedFilters) > 0)
                                        <button
                                            class="transition-color rounded px-2 py-1 font-semibold hover:bg-red-500 hover:text-white"
                                            x-on:click="$wire.clearFilters()">Clear Filters
                                        </button>
                                    @endif
                                </div>

                                <div
                                    id="lightGallery"
                                    class="gallery mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">

                                    @foreach ($galleryImages as $galleryImage)
                                        @if ($galleryImage->hasMedia('gallery_images'))
                                            <div data-src="{{ $galleryImage->getFirstMediaUrl('gallery_images') }}"
                                                 class="group relative cursor-pointer gallery_{{ $galleryImage->id }}"
                                                 wire:key="gallery_{{ $galleryImage->id }}">
                                                <figure
                                                    class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-md shadow group-hover:opacity-75">
                                                    <div data-caption="{{ $galleryImage->name }}"
                                                         class="transform bg-white transition duration-150 ease-in-out hover:-translate-y-1 hover:scale-105">
                                                        <div class="aspect-h-1 aspect-w-1">
                                                            {{ $galleryImage->getFirstMedia('gallery_images')->img('preview')->attributes([
                                                                    'alt' => $galleryImage->name,
                                                                    'class' => 'mx-auto rounded-md object-cover overflow-hidden',
                                                                    'loading' => 'lazy',
                                                                ]) }}
                                                        </div>
                                                        <div class="col-span-3 text-center">
                                                            <figcaption class="sr-only px-3 text-sm">
                                                                {{ $galleryImage->name }}</figcaption>
                                                        </div>
                                                    </div>
                                                </figure>
                                            </div>
                                        @endif
                                    @endforeach

                                </div>

                            </div>
                        </div>

                        <div class="mx-auto mt-12 px-8">
                            {{ $galleryImages->links() }}
                        </div>

                    </div>
                    <!-- /End replace -->

                </div>
            </div>
        </main>
    </div>
</div>

@push('meta')
    @if (!$galleryImages->onFirstPage())
        <link rel="prev" href="{{ $galleryImages->previousPageUrl() }}">
    @endif
    @if ($galleryImages->hasMorePages())
        <link rel="next" href="{{ $galleryImages->nextPageUrl() }}">
    @endif
@endpush

@push('head-styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/css/lightgallery.min.css"
          integrity="sha512-F2E+YYE1gkt0T5TVajAslgDfTEUQKtlu4ralVq78ViNxhKXQLrgQLLie8u1tVdG2vWnB3ute4hcdbiBtvJQh0g=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/css/lg-thumbnail.min.css"
          integrity="sha512-GRxDpj/bx6/I4y6h2LE5rbGaqRcbTu4dYhaTewlS8Nh9hm/akYprvOTZD7GR+FRCALiKfe8u1gjvWEEGEtoR6g=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/css/lg-transitions.min.css"
          integrity="sha512-lm04w74LemGhpRPg5018iANiFRlA4Dxhrh8jxH8LQtq/EAXG+MdkbVv7aEXPpN+d6D/72M5xNTjhCQ4lPxg7vA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
@endpush

@push('footer-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/lightgallery.min.js"
            integrity="sha512-dSI4QnNeaXiNEjX2N8bkb16B7aMu/8SI5/rE6NIa3Hr/HnWUO+EAZpizN2JQJrXuvU7z0HTgpBVk/sfGd0oW+w=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/plugins/thumbnail/lg-thumbnail.min.js"
            integrity="sha512-Jx+orEb1KJtJ6Ajfshhr7is0zqgUC7H9ylk76KMtB9Ea2WAf/Muyzpe9zvBAYQQQKdAbj+rNYEorsRQLsmRafA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush
