<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Image Format
    |--------------------------------------------------------------------------
    |
    | This option controls the default format for processed images.
    | Supported formats: "webp", "png", "jpg", "jpeg"
    |
    */

    'format' => env('IMAGE_FORMAT', 'webp'),

    /*
    |--------------------------------------------------------------------------
    | Default Image Quality
    |--------------------------------------------------------------------------
    |
    | This option controls the default quality for image compression.
    | Range: 1-100 (higher is better quality but larger file size)
    | For PNG: 0-9 (compression level, 0 = no compression)
    |
    */

    'quality' => env('IMAGE_QUALITY', 85),

    /*
    |--------------------------------------------------------------------------
    | Default Storage Disk
    |--------------------------------------------------------------------------
    |
    | This option controls which disk to use for storing processed images.
    | Default: "public" - stores in storage/app/public
    |
    */

    'disk' => env('IMAGE_DISK', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Maximum Image Dimensions
    |--------------------------------------------------------------------------
    |
    | Default maximum width and height for processed images.
    | Set to null for no limit.
    |
    */

    'max_width' => env('IMAGE_MAX_WIDTH', 2000),
    'max_height' => env('IMAGE_MAX_HEIGHT', 2000),

    /*
    |--------------------------------------------------------------------------
    | Thumbnail Settings
    |--------------------------------------------------------------------------
    |
    | Default dimensions for thumbnails.
    |
    */

    'thumbnail' => [
        'width' => env('IMAGE_THUMBNAIL_WIDTH', 300),
        'height' => env('IMAGE_THUMBNAIL_HEIGHT', 300),
        'quality' => env('IMAGE_THUMBNAIL_QUALITY', 80),
    ],

];

