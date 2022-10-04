<?php

return [
    /**
     * The disk that the Filament admin panel will save the image files too.
     */

    'media_library' => [
        'disk_name' => 'public',
    ],

    /**
     * Tag types used to group gallery image filters. These are used to create the
     * tag input fields on the gallery image resource forms. This package uses
     * spatie/laravel-tags package to manage the tags.
     */

    'tag_types' => [
        'Type 1',
        'Type 2',
        'Type 3',
    ],

    /**
     * The default image sizes used to generate the image conversions for the
     * preview (thumbnail) images.
     */

    'preview_image_size' => [
        'width'  => 300,
        'height' => 300,
    ],

];
