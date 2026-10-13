<?php

return [
    'gemini' => [
        'api_key' => env('GEMINI_API_KEY') ?: env('GOOGLE_API_KEY'),
        'model' => env('GEMINI_MODEL', 'gemini-3.8-flash'),
    ],
];
