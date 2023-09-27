<?php

return [

    'navigation_group_label' => 'Sortable Gallery',

    /**
     * The disk that the Filament admin panel will save the image files too.
     */
    'media_library' => [
        'disk_name' => 'public',
    ],

    /**
     *   Set amount of images per page in the gallery
     */
    'images_per_page' => 16,

    /**
     * The default image sizes used to generate the image conversions for the
     * preview (thumbnail) images.
     */
    'preview_image_size' => [
        'width' => 300,
        'height' => 300,
    ],

];
