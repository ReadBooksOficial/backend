<?php

return [

    'limits' => [
        'text_post' => env('LIMIT_TEXT_POST', 500),
        'text_comment' => env('LIMIT_TEXT_COMMENT', 500),
        'text_report' => env('LIMIT_TEXT_REPORT', 500),
        'name_community' => env('LIMIT_NAME_COMMUNITY', 100),
        'description_community' => env('LIMIT_DESCRIPTION_COMMUNITY', 200),
        'text_ads' => 500,
        'price_per_views_ads' => 0.05,
        'name_ads' => env('LIMIT_NAME_COMMUNITY', 100),
        'max_ban_days' => env('MAX_BAN_DAYS', 100),
        'request_comments' => env('LIMIT_REQUEST_COMMENTS', 10),
    ],

    'urls' => [
        'pacoca_api' => env('PACOCA_API_URL', 'https://laravel.pacoca.net/api'),
        'readbooks_api' => env('READBOOKS_API_URL', 'https://api.readbooks.site/api/v2'),
        'nuestra_api' => env('NUESTRA_API_URL', ''),
        'bucket_pacoca' => env('BUCKET_PACOCA_URL', 'https://pacoca.nyc3.cdn.digitaloceanspaces.com'),
        'bucket_readbooks' => env('BUCKET_READBOOKS_URL', 'https://api.readbooks.site'),
        'readbooks' => env('READBOOKS_URL', 'https://readbooks.site'),
        'pacoca' => env('PACOCA_URL', 'https://pacoca.net'),
        'rita' => env('RITA_URL', 'https://rita.pacoca.site'),
        'cronos' => env('CRONOS_URL', 'https://cronos.pacoca.site'),
        'nuestra' => env('NUESTRA_URL', 'https://nuestra.vercel.app'),
    ],

];
