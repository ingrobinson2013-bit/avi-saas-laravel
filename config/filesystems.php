<?php

return [

    'default' => env('FILESYSTEM_DISK', 'public'),

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        'r2' => [
            'driver' => 's3',
            'key' => env('CLOUDFLARE_R2_ACCESS_KEY_ID', env('AWS_ACCESS_KEY_ID')),
            'secret' => env('CLOUDFLARE_R2_SECRET_ACCESS_KEY', env('AWS_SECRET_ACCESS_KEY')),
            'region' => 'auto',
            'bucket' => env('CLOUDFLARE_R2_BUCKET', env('AWS_BUCKET')),
            'url' => env('CLOUDFLARE_R2_URL', env('AWS_URL')),
            'endpoint' => env('CLOUDFLARE_R2_ENDPOINT', env('AWS_ENDPOINT')),
            'use_path_style_endpoint' => env('CLOUDFLARE_R2_USE_PATH_STYLE_ENDPOINT', false),
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

    ],

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
