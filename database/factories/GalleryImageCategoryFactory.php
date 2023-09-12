<?php

namespace Tjmpromos\SortableGallery\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tjmpromos\SortableGallery\Models\GalleryImageCategory;

class GalleryImageCategoryFactory extends Factory
{
    protected $model = GalleryImageCategory::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
        ];
    }
}
