<?php

namespace Tjmpromos\SortableGallery\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tjmpromos\SortableGallery\Models\GalleryImage;

class GalleryImageFactory extends Factory
{
    protected $model = GalleryImage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'is_active' => fake()->boolean(),
        ];
    }
}
