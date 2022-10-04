<?php

namespace Tjmpromos\SortableGallery\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Tjmpromos\SortableGallery\SortableGalleryServiceProvider;


class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

//        Factory::guessFactoryNamesUsing(
//            fn (string $modelName) => 'Tjmpromos\\SortableGallery\\Database\\Factories\\'.class_basename($modelName).'Factory'
//        );
    }

    protected function getPackageProviders($app)
    {
        return [
            SortableGalleryServiceProvider::class,
            LivewireServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_skeleton_table.php.stub';
        $migration->up();
        */
    }
}